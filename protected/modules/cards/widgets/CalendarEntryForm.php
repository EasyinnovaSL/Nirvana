<?php

namespace humhub\modules\cards\widgets;

class CalendarEntryForm extends \humhub\modules\content\widgets\WallCreateContentForm
{
	public $card_id;

	/**
	 * @inheritdoc
	 */
	public $submitUrl = '/cards/calendar/create';

	/**
	 * @inheritdoc
	 */
	public function renderForm()
	{
		return $this->render('calendarForm', array());
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->contentContainer instanceof \humhub\modules\space\models\Space) {

			if (!$this->contentContainer->permissionManager->can(new \humhub\modules\polls\permissions\CreatePoll())) {
				return;
			}
		}

		return parent::run();
	}

}

?>