<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cards;

use humhub\modules\calendar\models\CalendarEntryParticipant;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\SpaceUserRole;
use humhub\modules\cards\models\UserRole;
use humhub\modules\cards\models\UserRoleWorkflow;
use humhub\modules\cards\models\WorkflowSpaceType;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\Cards;
use humhub\modules\cards\models\Step;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\widgets\StatusLabel;
use humhub\modules\content\widgets;
use humhub\modules\cards\widgets\WallCreateForm;
use humhub\modules\polls\models\PollAnswerUser;
use humhub\modules\tasks\models\Task;
use humhub\modules\tasks\models\TaskUser;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use Yii;
use yii\base\Event;

/**
 * Description of Events
 *
 * @author Infoself
 */
class Events extends \yii\base\Object
{

    /**
     * Add Main Menu to top Bar
     *
     * @param type $event
     */

    public static function onSpaceMenuInit($event)
    {
        $space = $event->sender->space;

        // Is Module enabled on this workspace?
            $event->sender->addItem(array(
                'label' => "What's Next?",
                'group' => 'modules',
                'sortOrder' => 0,
                'url' => $space->createUrl('/cards/card/show'),
                'icon' => '<i class="fa fa-home"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'cards'),
            ));
    }



    public static function onWallEntryControlsInit($event)
    {
        $object = $event->sender->object;

        if(!$object instanceof Card) {
            return;
        }

        $event->sender->removeWidget(widgets\DeleteLink::className());
        $event->sender->removeWidget(widgets\EditLink::className());
        $event->sender->removeWidget(widgets\NotificationSwitchLink::className());
        $event->sender->removeWidget(widgets\PermaLink::className());
        $event->sender->removeWidget(widgets\StickLink::className());

    }



    public static function onWallEntryAddonsInit($event)
    {
        $object = $event->sender->object;
        if(!$object instanceof Card) {
            return;
        }

        $event->sender->removeWidget(widgets\WallEntryLinks::className());

    }

    public static function onSpaceMembership($event)
    {
        $object = $event->sender;

        StepFlow::insertFlow($object->user_id, $object->space_id);
    }

    /**
     * @param $space
     * @param  $cards
     * @return int
     */
    
    public static function c_ ($space, $cards) {

        $date_end_card = new \DateTime('now +7 day');

        $card = new Card();
        $card->scenario = Card::SCENARIO_CREATE;
        $card->card_id = $cards->getPrimaryKey();
        $card->card_end_date = $date_end_card->format('Y-m-d H:i:s');
        $card->space_id = $space->id;
        $card->hide = $cards->hide;
        $card->content->container = $space;
        $card->save();

        return $card->id;
    }

    public static function onSpaceCreated($event)
    {

        $space =  $event->sender;
        $workflow = StepFlow::currentWorkflow($space);

        if (!$workflow) return;

            $cards = Cards::find()->where( array('workflow_id' => $workflow->workflow_id) )->all();

            foreach ($cards as $card)
                Events::c_($space, $card);


    }

    public static function manageEvents($event)
    {

        Event::on(PollAnswerUser::className(), PollAnswerUser::EVENT_AFTER_INSERT,
            array('humhub\modules\cards\controllers\PollController', 'onPollAnswerInsert'));

        Event::on(CalendarEntryParticipant::className(), CalendarEntryParticipant::EVENT_AFTER_INSERT,
            array('humhub\modules\cards\controllers\CalendarController', 'onCalendarParticipantInsert'));

        Event::on(Task::className(), Task::EVENT_AFTER_UPDATE,
            array('humhub\modules\cards\controllers\LinkController', 'onTaskComplete'));

    }



    public static function onPollCreated($event)
    {

        if ($event->action->actionMethod != "actionShow") {

        }
    }

    public static function onCronDailyRun($event) {

        $controller = $event->sender;
        $controller->stdout("Sending Deadline E-mails ");

        $date_end_card = new \DateTime('now +1 day');

        $cards_deadline = Card::findAll(array('card_end_date' => $date_end_card->format('Y-m-d H:i:s')));

        foreach ($cards_deadline as $card_deadline) {

            $user_card = UserCard::findOne(array('card_id' => $card_deadline->id));

            $user = $user_card->getUser();

            $mail = Yii::$app->mailer->compose([
                'html' => '@humhub/modules/cards/views/mails/WarningDeadline',
                'text' => '@humhub/modules/cards/views/mails/plaintext/WarningDeadline'
            ], [
                'user' => $user,
                'card' => $card_deadline
            ]);
            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($user->email);
            $mail->setSubject(Yii::t('UserModule.forms_AccountRecoverPasswordForm', 'Password Recovery'));
            $mail->send();
        }

        $controller->stdout('done.' . PHP_EOL, \yii\helpers\Console::FG_GREEN); //TODO: review
    }
}
