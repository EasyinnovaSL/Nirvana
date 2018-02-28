<?php

namespace humhub\modules\nda\controllers;

use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\models\Card;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\space\models\Space;
use humhub\modules\post\models\Post;
use humhub\modules\cards\models\CardContent;
use humhub\modules\tasks\models\Task;
/**
 * Default controller for the `example` module
 */
class PostTaskController extends ContentContainerController
{

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }


    public function actionPost()
    {
        // Check createPost Permission
        if (!$this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost())) {
            return [];
        }

        $post = new Post();
        $post->message = \Yii::$app->request->post('message');

        $r_ = \humhub\modules\content\widgets\WallCreateContentForm::create($post, $this->contentContainer);




        if (isset($r_['wallEntryId'])) {
            $newContentRelated = new CardContent();
            $newContentRelated->card_id = Yii::$app->request->post('card_id');
            $newContentRelated->content_related_id = $post->getContent()->one()->id;
            $newContentRelated->tag = Post::className();
            $newContentRelated->save();

            ////////Add Task////////
            $newTask = new Task();
            $newTask->title = "Provide more datails or missing info about their interest";
            $newTask->content->container = $this->contentContainer;
            $newTask->status = 1;
            $newTask->max_users = 0;
            $newTask->validate();
            $newTask->save();
            StepFlow::CardContentRelated(Yii::$app->request->post('card_id'), $newTask->getContent()->one()->id, Task::className(), 0);
            ////////////////////

            $card = Card::findOne(Yii::$app->request->post('card_id'));
            $cards_related = $card->getRelatedCards();

            foreach ($cards_related as $card_related) {

              $otherNewContentRelated = new CardContent();
              $otherNewContentRelated->card_id = $card_related->id;
              $otherNewContentRelated->content_related_id = $post->getContent()->one()->id;
              $otherNewContentRelated->tag = Post::className();
              $otherNewContentRelated->save();

            }




        }

        return \humhub\modules\content\widgets\WallCreateContentForm::create($post, $this->contentContainer);

        //return $r_;

    }




}
