<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cfiles\models\File;
use humhub\modules\linklist\models\Category;
use humhub\modules\linklist\models\Link;
use humhub\modules\tasks\models\Task;
use humhub\modules\tasks\models\TaskUser;
use humhub\modules\user\models\User;
use humhub\modules\cards\models\EasyppProfile;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\cards\models\EasyppLinks;

/**
 * Default controller for the `example` module
 */
class LinkController extends ContentContainerController
{
    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    /**
     * Shows the questions tab
     */

    public function actionIndex()
    {
        return $this->renderAjax('index', [
            'contentContainer' => $this->contentContainer,
            'currentFolder' => $this->getCurrentFolder(),
            'itemCount' => 0
        ]);
    }

    public function actionCreate()
    {
        $contents = [];

        $category_link = Category::find()->contentContainer($this->contentContainer)->readable()->one();

        if (!$category_link) {
            $category_link = new Category();
            $category_link->title = "External tools";
            $category_link->content->container = $this->contentContainer;
            $category_link->save();
        }

        $link = new Link();
        $link->category_id = $category_link->id;
        $link->title = "EasyPP";
        $link->description = "Link to EasyPP profile";
        $link->content->container = $this->contentContainer;

        if ($link->load(Yii::$app->request->post()) && $link->validate() &&  $link->save()) {
            $card_id = Yii::$app->request->get('card_id');

            $contents[] = array('id' => $link->getContent()->one()->id, 'tag' => Link::className(),
                'order' => 1);

            foreach ($contents as $content) {
                StepFlow::CardContentRelated($card_id, $content['id'], $content['tag'], $content['order']);
                StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_ONGOING);
            }

            return true;

            //return $newTask->id;
        }
		Yii::$app->response->format = 'json';
		return ['error' => true];

    }

    public function actionSubmitted()
    {
        $card_id = Yii::$app->request->get('card_id');
        $space_id = Yii::$app->request->get('space_id');

        // Save easypp profile
        $easyppprofile = Yii::$app->request->get('easyppprofile');
        $newProfile = new EasyPPProfile();
        $newProfile->space_id = $space_id;
        $newProfile->profile = $easyppprofile;
        $newProfile->save();

        // Save link
        $category_link = Category::find()->contentContainer($this->contentContainer)->readable()->one();
        if (!$category_link) {
            $category_link = new Category();
            $category_link->title = "External tools";
            $category_link->content->container = $this->contentContainer;
            $category_link->save();
        }
        $link = new Link();
        $link->category_id = $category_link->id;
        $link->title = "EasyPP";
        $link->description = "Link to EasyPP profile";
        $link->content->container = $this->contentContainer;

        $url = EasyppLinks::findOne(["space_id" => $space_id])->innovator_link;
        if ($link->load(["href" => $url], '') && $link->validate() && $link->save()) {
            $card_id = Yii::$app->request->get('card_id');

            $contents[] = array('id' => $link->getContent()->one()->id, 'tag' => Link::className(),
                'order' => 1);

            foreach ($contents as $content) {
                StepFlow::CardContentRelated($card_id, $content['id'], $content['tag'], $content['order']);
            }
        }

        StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

        $card = Card::findOne($card_id);
        $cards_related = $card->getRelatedCards();
        foreach ($cards_related as $card_related) {
            $user_cards_step = UserCard::findOne(array('card_id' => $card_related->id));
            if (!$user_cards_step) continue;
            StepFlow::updateFlowStatus($card_related->id, UserCard::STATUS_COMPLETED,
                $user_cards_step->user_id);
        }

        Yii::$app->response->format = 'json';
        return ['error' => false];
    }

    public function actionGotlink()
    {
        $card_id = Yii::$app->request->get('card_id');
        $space_id = Yii::$app->request->get('space_id');
        StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_ONGOING);

        // Save links
        $advisorlink = Yii::$app->request->get('advisorlink');
        $innovatorlink = Yii::$app->request->get('innovatorlink');
        $newLinks = new EasyPPLinks();
        $newLinks->space_id = $space_id;
        $newLinks->advisor_link = $advisorlink;
        $newLinks->innovator_link = $innovatorlink;
        $newLinks->save();

        Yii::$app->response->format = 'json';
        return ['error' => false];
    }

    public static function onTaskComplete($event) {

        $task = $event->sender;

        if (!$task instanceof Task) return;

        $content    = $task->getContent()->one();
        $user       = $task->updated_by;

        if ($user == $content->created_by) return;

        StepFlow::updateCardContentStatus($content->id, $content->getContentContainer()->one()->pk, $user );

    }

}
