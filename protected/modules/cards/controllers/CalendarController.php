<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\calendar\models\CalendarEntryParticipant;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\widgets\ContentCard;
use humhub\modules\cards\widgets\NewPoll;
use humhub\modules\content\widgets\WallEntryLinks;
use humhub\modules\polls\models\Poll;
use humhub\modules\polls\permissions\CreatePoll;
use humhub\modules\space\widgets\InviteButton;
use humhub\modules\tasks\widgets\MyTasks;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;

/**
 * Default controller for the `example` module
 */
class CalendarController extends ContentContainerController
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
	public function actionShow()
	{
		return $this->renderAjax('show', array(
			'contentContainer' => $this->contentContainer,
			'card_id' =>  Yii::$app->request->get('card_id')
		));
	}



	public static function onEventCreate($event) {


	}


	public function actionEdit()
	{

			if (!$this->contentContainer->permissionManager->can(new \humhub\modules\calendar\permissions\CreateEntry())) {
				throw new HttpException(403, 'No permission to add new entries');
			}

			$calendarEntry = new CalendarEntry();
			$calendarEntry->content->container = $this->contentContainer;

			if (Yii::$app->request->get('fullCalendar') == 1) {
				\humhub\modules\calendar\widgets\FullCalendar::populate($calendarEntry, Yii::$app->timeZone);
			}


		if ($calendarEntry->all_day) {
			// Timezone Fix: If all day event, remove time of start/end datetime fields
			$calendarEntry->start_datetime = preg_replace('/\d{2}:\d{2}:\d{2}$/', '', $calendarEntry->start_datetime);
			$calendarEntry->end_datetime = preg_replace('/\d{2}:\d{2}:\d{2}$/', '', $calendarEntry->end_datetime);
			$calendarEntry->start_time = '00:00';
			$calendarEntry->end_time = '23:59';
		}

		if ($calendarEntry->load(Yii::$app->request->post()) && $calendarEntry->validate() && $calendarEntry->save()) {


			$card = Card::findOne(Yii::$app->request->post('card_id'));

			$cards_related = $card->getRelatedCards();

//			if (isset($r_['wallEntryId'])) {
			$card_id = Yii::$app->request->post('card_id');
			StepFlow::CardContentRelated($card_id, $calendarEntry->getContent()->one()->id, CalendarEntry::className());
			StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_ONGOING);
//			}
			// After closing modal refresh calendar or page
			$output = "<script>";
			$output .= 'if(typeof $("#calendar").fullCalendar != "undefined") { $("#calendar").fullCalendar("refetchEvents"); } else { location.reload(); }';
			$output .= "</script>";

			$output .= $this->renderModalClose();

			return $this->renderAjaxContent($output);
		}

		return $this->renderAjax('modal', [
			'calendarEntry' => $calendarEntry,
			'card_id'=> Yii::$app->request->get('card_id'),
			'contentContainer' => $this->contentContainer,
			'createFromGlobalCalendar' => false
		]);
	}


	public static function onCalendarParticipantInsert($event) {

		$calendar_entry_participant = $event->sender;


		if (!$calendar_entry_participant instanceof CalendarEntryParticipant) return;

		$calendar_entry       	= $calendar_entry_participant->getCalendarEntry()->one();
		$content    			= $calendar_entry->getContent()->one();
		$user       			= $calendar_entry_participant->getUser()->one();


		if ($user->id == $content->created_by) return;

		StepFlow::updateCardContentStatus($content->id, $content->getContentContainer()->one()->pk, $user->id);

	}
}
