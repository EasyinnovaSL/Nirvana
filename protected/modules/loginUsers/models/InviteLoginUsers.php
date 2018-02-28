<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\loginUsers\models;

use Yii;
use yii\helpers\Url;


/**
 * This is the model class for table "user_invite".
 *
 * @property integer $id
 * @property integer $user_originator_id
 * @property integer $space_invite_id
 * @property string $email
 * @property string $source
 * @property string $token
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $language
 * @property string $firstname
 * @property string $lastname
 */
class InviteLoginUsers extends \humhub\modules\user\models\Invite
{

    private $groupType = null;


    public function setGroupType($groupType = null){
        $this->groupType = $groupType;
    }

    public function getGroupType(){
        return $this->groupType;
    }

    public function selfInvite()
    {
        $this->source = self::SOURCE_SELF;
        $this->language = Yii::$app->language;

        // Delete existing invite for e-mail - but reuse token
        $existingInvite = InviteLoginUsers::findOne(['email' => $this->email]);
        if ($existingInvite !== null) {
            $this->token = $existingInvite->token;

            /* First find the old email */
            $existingUserInviteGroup = UserInviteGroup::findOne(['user_invite_id' => $existingInvite->id]);
            if ($existingUserInviteGroup !== null) {
                $existingUserInviteGroup->delete();
            }

            /* Delete the user_invite row */
            $existingInvite->delete();
        }

        if ($this->allowSelfInvite() && $this->validate() && $this->save()) {

            /* We need to create a UserInviteGroup and save it the group of the user */
            $newUserInviteGroup = new UserInviteGroup();
            $newUserInviteGroup->user_invite_id = $this->id;
            $newUserInviteGroup->group_id = $this->getGroupType();

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $resultSaveInUserInviteGroup = $newUserInviteGroup->save();

                if ($resultSaveInUserInviteGroup) {

                    $this->sendInviteMail();

                    $transaction->commit();

                    return true;
                }else{
                    return false;
                }

            } catch (Exception $e) {
                if(isset($transaction)){
                    $transaction->rollBack();
                }
                Yii::error($e->getMessage());
                return false;
            }
        }

        return false;
    }

    /**
     * Sends the invite e-mail
     */
    public function sendInviteMail()
    {
        $module = Yii::$app->moduleManager->getModule('user');
        $registrationUrl = Url::to(['/loginUsers/registration', 'token' => $this->token], true);

        // User requested registration link by its self
        if ($this->source == self::SOURCE_SELF) {

            $mail = Yii::$app->mailer->compose([
                'html' => '@app/modules/loginUsers/views/mails/UserInviteSelf',
                'text' => '@app/modules/loginUsers/views/mails/plaintext/UserInviteSelf'
                    ], [
                'token' => $this->token,
                'registrationUrl' => $registrationUrl
            ]);
            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($this->email);
            $mail->setSubject(Yii::t('UserModule.views_mails_UserInviteSelf', 'Registration Link'));
            $mail->send();
        } elseif ($this->source == self::SOURCE_INVITE && $this->space !== null) {

            if($module->sendInviteMailsInGlobalLanguage) {
                Yii::$app->language = Yii::$app->settings->get('defaultLanguage');
            }

            $mail = Yii::$app->mailer->compose([
                'html' => '@humhub/modules/user/views/mails/UserInviteSpace',
                'text' => '@humhub/modules/user/views/mails/plaintext/UserInviteSpace'
                    ], [
                'token' => $this->token,
                'originator' => $this->originator,
                'originatorName' => $this->originator->displayName,
                'token' => $this->token,
                'space' => $this->space,
                'registrationUrl' => $registrationUrl
            ]);
            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($this->email);
            $mail->setSubject(Yii::t('UserModule.views_mails_UserInviteSpace', 'Invitation to join: {space}', ['space' => $this->space->name]));
            $mail->send();

            // Switch back to users language
            if (Yii::$app->user->language !== "") {
                Yii::$app->language = Yii::$app->user->language;
            }
        } elseif ($this->source == self::SOURCE_INVITE) {

            // Switch to systems default language
            if($module->sendInviteMailsInGlobalLanguage) {
                Yii::$app->language = Yii::$app->settings->get('defaultLanguage');
            }

            $mail = Yii::$app->mailer->compose([
                'html' => '@humhub/modules/user/views/mails/UserInvite',
                'text' => '@humhub/modules/user/views/mails/plaintext/UserInvite'
                    ], [
                'originator' => $this->originator,
                'originatorName' => $this->originator->displayName,
                'token' => $this->token,
                'registrationUrl' => $registrationUrl
            ]);
            $mail->setFrom([Yii::$app->settings->get('mailer.systemEmailAddress') => Yii::$app->settings->get('mailer.systemEmailName')]);
            $mail->setTo($this->email);
            $mail->setSubject(Yii::t('UserModule.invite', 'Invitation to join'));
            $mail->send();

            // Switch back to users language
            if (Yii::$app->user->language !== "") {
                Yii::$app->language = Yii::$app->user->language;
            }
        }
    }

}
