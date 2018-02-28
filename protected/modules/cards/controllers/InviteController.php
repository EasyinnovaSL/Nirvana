<?php

namespace humhub\modules\cards\controllers;


use Yii;

use yii\helpers\Url;
use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\space\models\Membership;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;

/**
 * Default controller for the `example` module
 */
class InviteController extends ContentContainerController
{
    const CARD_TYPE = 2;

    public function behaviors()
    {
        return array(
            StepFlow::className()
        );
    }

    public static function onInviteInsert($event)
    {
        if(!$event->sender->invite &&
           !$event->sender->inviteExternal) return;

        $card = Card::find()->leftJoin('cards',
            'card.card_id=cards.id')->where(array('card_type_id' => self::CARD_TYPE,
            'space_id' => $event->sender->space->id))->one();

        StepFlow::updateFlowStatus($card->getPrimaryKey(), StepUserSpace::STATUS_COMPLETED);
    }

    public static function onInviteNotificationSent($event)
    {
        if($event->name == "afterInsert" && $event->sender->status == Membership::STATUS_INVITED && $event->sender->originator_user_id != $event->sender->user_id){

            $invitedUser = User::findOne(['id' => $event->sender->user_id]);

            $originatorUserToInviteAnother = User::findOne(['id' =>  $event->sender->originator_user_id]);

            $spaceToBeInvited = Space::findOne(array('id' => $event->sender->space_id));

            //$registrationUrl = Url::to(['/space/space', 'guid' => $spaceToBeInvited->guid], true);
            $registrationUrl = Url::to(['/cards/card/show', 'sguid' => $spaceToBeInvited->guid], true);

            // Switch to user default language
            Yii::$app->language = $invitedUser->language;

            $mail = Yii::$app->mailer->compose([
                'html' => '@app/modules/loginUsers/views/mails/UserInviteSpaceWithoutRegister',
                'text' => '@app/modules/loginUsers/views/mails/plaintext/UserInviteSpaceWithoutRegister'
            ], [
               'token' => "sss",
                'originator' => $originatorUserToInviteAnother,
                'originatorName' => $originatorUserToInviteAnother->displayName,
                'space' => $spaceToBeInvited,
                'registrationUrl' => $registrationUrl
            ]);

            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($invitedUser->email);
            $mail->setSubject(Yii::t('UserModule.views_mails_UserInviteSpace', 'Invitation to join: {space}', ['space' => $spaceToBeInvited->name]));
            $mail->send();


            Yii::$app->language = Yii::$app->user->language;

        }
    }
}
