<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\Cards;
use humhub\modules\cards\models\UserCard;
use humhub\modules\user\models\User;
use humhub\modules\companies\models\Company;
use humhub\modules\companies\models\CompanySpace;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\content\components\actions\Stream;
use humhub\modules\cards\models\EasyppProfile;

/**
 * Default controller for the `example` module
 */
class CardController extends ContentContainerController
{
    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    public function actions()
    {
        return array(
            'stream' => array(
                'class' => \humhub\modules\cards\components\StreamAction::className(),
                'mode' => \humhub\modules\cards\components\StreamAction::MODE_NORMAL,
                'contentContainer' => $this->contentContainer
            ),
        );
    }

    /**
     * Shows the questions tab
     */
    public function actionShow()
    {

        $user = User::findOne(['id' => Yii::$app->user->getId()]);

        $next_innovator = (boolean) Yii::$app->request->get('next_innovator');
        if ($next_innovator) {
            $this->enableNextUserStep( $this->contentContainer->getPrimaryKey());
        } else {
            $isAdvisor = $user->getGroups()->where(array('id' => 3))->one();
            if ($isAdvisor) {
                $this->enableNextUserStep( $this->contentContainer->getPrimaryKey());
            }
        }

        $user_steps_info = $this->infoUserSteps(  $this->contentContainer->getPrimaryKey(), $user->id );

        return $this->render('show', array(
            'user_id'   => $user->id,
            'welcomeScreen' => !$user_steps_info->hasStep,
            'space_id'  => $this->contentContainer->getPrimaryKey(),
            'contentContainer' => $this->contentContainer
        ));
    }


    public function actionShowSteps() {
        
        return \humhub\modules\cards\widgets\MySteps::widget(array('user_id' => Yii::$app->user->getId(),
            'space_id' => $this->contentContainer->getPrimaryKey(),
            'space' => $this->contentContainer));
    }


	/**
	 * Shows the questions tab
	 */
	public function actionDeadline() {
		return $this->renderAjax('deadline', array(
			'contentContainer' => $this->contentContainer,
			'card' =>  Card::findOne(Yii::$app->request->get('card_id'))
		));
	}

	public function actionSubmitdeadline() {
		$card = Card::findOne(Yii::$app->request->get('card_id'));
		$card->scenario = Card::SCENARIO_CREATE;
		$card->load(Yii::$app->request->post());
		if ($card->validate() && $card->save()) {
			// After closing modal refresh calendar or page
			$output = "<script>";
			$output .= "</script>";
			$output .= $this->renderModalClose();
			return $this->renderAjaxContent($output);
		}

	}



	/**
     * Shows the questions tab
     */
    public function actionDismiss() {
		$card_id = Yii::$app->request->get('card_id');
		StepFlow::updateFlowStatus($card_id,  UserCard::STATUS_DISMISSED);

        $output = "<script>";
        $output .= "</script>";
        $output .= $this->renderModalClose();
        return $this->renderAjaxContent($output);
    }

    public function actionCompleted() {
        $card_id = Yii::$app->request->get('card_id');

        $this->cardActionDone($card_id);

        StepFlow::updateFlowStatus($card_id,  UserCard::STATUS_COMPLETED);

        $output = "<script>";
        $output .= "</script>";
        $output .= $this->renderModalClose();
        return $this->renderAjaxContent($output);
    }

    public function actionOngoing() {
        $card_id = Yii::$app->request->get('card_id');
        StepFlow::updateFlowStatus($card_id,  UserCard::STATUS_ONGOING);

        $output = "<script>";
        $output .= "</script>";
        $output .= $this->renderModalClose();
        return $this->renderAjaxContent($output);
    }

	/**
     * Shows the questions tab
     */
    public function actionUnDismiss() {
		$card_id = Yii::$app->request->get('card_id');
		StepFlow::updateFlowStatus($card_id,  UserCard::STATUS_PENDING);

        $output = "<script>";
        $output .= "</script>";
        $output .= $this->renderModalClose();
        return $this->renderAjaxContent($output);
    }

    public function cardActionDone($card_id) {
        $card = Card::findOne($card_id);

        $card_def = Cards::findOne(['id' => $card->card_id]);

        switch ($card_def->card_type_id) {
            case 15:
                $space_id = $card->space_id;
                $profile = EasyppProfile::findOne(['space_id' => $space_id]);
                if ($profile != null) {
                    $profile->online = true;
                    $profile->update();
                }
                break;
        }
    }
    
}
