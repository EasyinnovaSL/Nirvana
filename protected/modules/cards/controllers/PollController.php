<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\widgets\ContentCard;
use humhub\modules\polls\models\Poll;
use humhub\modules\polls\models\PollAnswerUser;
use humhub\modules\polls\permissions\CreatePoll;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;

/**
 * Default controller for the `example` module
 */
class PollController extends ContentContainerController
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

        $poll = new Poll();
        $poll->scenario = Poll::SCENARIO_CREATE;
        $poll->question = Yii::$app->request->post('question');
        $poll->setNewAnswers(Yii::$app->request->post('newAnswers'));
        $poll->allow_multiple = Yii::$app->request->post('allowMultiple', 0);
        $poll->anonymous = Yii::$app->request->post('anonymous', 0);
        $poll->is_random = Yii::$app->request->post('is_random', 0);

        $r_ = \humhub\modules\polls\widgets\WallCreateForm::create($poll, $this->contentContainer);


        if (isset($r_['wallEntryId'])) {
			$card_id = Yii::$app->request->post('card_id');
            StepFlow::CardContentRelated($card_id, $poll->getContent()->one()->id, Poll::className());
			StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_ONGOING);
        }

        return $r_;
    }

    public static function onPollAnswerInsert($event)
    {
        $poll_answer = $event->sender;

        if (!$poll_answer instanceof PollAnswerUser) return;

        $poll       = $poll_answer->getPoll()->one();
        $content    = $poll->getContent()->one();
        $user       = $poll_answer->getUser()->one();


        if ($user->id == $content->created_by) return;
        
        StepFlow::updateCardContentStatus($content->id, $content->getContentContainer()->one()->pk, $user->id);

    }

}
