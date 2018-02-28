<?php

namespace humhub\modules\cards\widgets;

class PollEntryForm extends \humhub\modules\content\widgets\WallCreateContentForm
{
    public $card_id;

    /**
     * @inheritdoc
     */
    public $submitUrl = '/cards/poll/create';

    /**
     * @inheritdoc
     */
    public function renderForm()
    {
        return $this->render('pollForm', array());
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