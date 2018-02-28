<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\widgets\ContentCard;
use humhub\modules\polls\models\Poll;
use humhub\modules\polls\permissions\CreatePoll;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;

/**
 * Default controller for the `example` module
 */
class MeetingController extends ContentContainerController
{
    const CARD_TYPE = 3;

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    /**
     * Shows the questions tab
     */
    public function actionShow()
    {
        return $this->renderAjax('show', array(
            'contentContainer' => $this->contentContainer,
            'card_id' =>  Yii::$app->request->get('card_id')
        ));
    }



    /**
     * Posts a new question  throu the question form
     *
     * @return type
     */
    public function actionCreate()
    {

        if (!$this->contentContainer->permissionManager->can(new CreatePoll())) {
            throw new HttpException(400, 'Access denied!');
        }

        $poll = new Meeting();
        $poll->scenario = Meeting::SCENARIO_CREATE;
        $poll->question = Yii::$app->request->post('question');
        $poll->setNewAnswers(Yii::$app->request->post('newAnswers'));
        $poll->allow_multiple = Yii::$app->request->post('allowMultiple', 0);
        $poll->anonymous = Yii::$app->request->post('anonymous', 0);
        $poll->is_random = Yii::$app->request->post('is_random', 0);

        $r_ = \humhub\modules\polls\widgets\WallCreateForm::create($poll, $this->contentContainer);

        if (isset($r_['wallEntryId'])) {
            $newContentRelated = new CardContent();
            $newContentRelated->card_id = Yii::$app->request->post('card_id');
            $newContentRelated->content_related_id = $poll->getContent()->one()->id;
            $newContentRelated->tag = Poll::className();
            $newContentRelated->save();
        }

        return $r_;
    }

}
