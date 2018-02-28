<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\emailwhitelist;

use Yii;
use yii\helpers\Url;
use humhub\modules\user\models\User;
use humhub\modules\enterprise\modules\emailwhitelist\models\forms\WhitelistSettingsForm;

/**
 * Emailwhitelist module
 *
 * @author buddha
 */
class Module extends \humhub\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\enterprise\modules\emailwhitelist\controllers';

    public static function onAdminGroupMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('EnterpriseModule.emailwhitelist', 'E-Mail Mapping'),
            'sortOrder' => 1000,
            'isActive' => (Yii::$app->controller->module->id == 'emailwhitelist'),
            'url' => Url::to(['/enterprise/emailwhitelist/group/index', 'groupId' => $event->sender->group->id]),
        ));
    }

    /**
     * Is executed when initializing the admin settings menu and activates the
     * User tab if the whitelist setting page is shown.
     * @param type $event
     */
    public static function onAdminUserMenuInit($event)
    {
        if (Yii::$app->controller->module && Yii::$app->controller->module->id == 'emailwhitelist' && Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'index') {
            $event->sender->setActive(Url::toRoute('/admin/authentication'));
        }
    }

    /**
     * Is executed when initializing the user setting menu and will add the emailwhitelist setting menu item.
     * @param type $event
     */
    public static function onAuthenticationMenuInit($event)
    {
        $event->sender->addItem([
            'label' => Yii::t('EnterpriseModule.emailwhitelist', 'Whitelist'),
            'url' => Url::toRoute(['/enterprise/emailwhitelist/admin/index']),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'emailwhitelist' && Yii::$app->controller->id == 'admin' && Yii::$app->controller->action->id == 'index'),
        ]);
    }

    /**
     * Is executed before validating the user registration form.
     * Here we check if the given user email matches the whitelist. 
     * Users which match the whitelist will automatically be approved. 
     * Users which do not match are disabled if the approval process is not enabled.
     * @param type $event
     */
    public static function onRegistrationBeforeValidate($event)
    {
        if (self::isEmptyWhitelist()) {
            return;
        }

        $registrationForm = $event->sender;
        $user = $registrationForm->models['User'];

        if (self::matchesWhitelist($user->email)) {
            $user->status = User::STATUS_ENABLED;
            $registrationForm->enableUserApproval = false;
        } else if (!Yii::$app->getModule('user')->settings->get('auth.needApproval')) {
            $user->status = User::STATUS_DISABLED;
            $user->addError('email', Yii::t('EnterpriseModule.emailwhitelist', 'The given email address is not allowed for registration!'));
        }
    }

    /**
     * Is executed before validating the invite model.
     * If the given mail does not match the whitelist and there is no approval process, we'll disallow the invite.
     * @param type $event
     */
    public static function onInviteBeforeValidate($event)
    {
        if (!self::matchesWhitelist($event->sender->email) && !Yii::$app->getModule('user')->settings->get('auth.needApproval')) {
            $event->sender->addError('email', Yii::t('EnterpriseModule.emailwhitelist', 'The given email address is not allowed for registration!'));
            $event->isValid = false;
        }
    }

    /**
     * Is executed before validating the invite form (Dashboard/Admin)
     * @param type $event
     */
    public static function onInviteFormBeforeValidate($event)
    {
        if (self::isEmptyWhitelist() || Yii::$app->getModule('user')->settings->get('auth.needApproval')) {
            return;
        }

        $disallowedEmails = [];
        foreach ($event->sender->getEmails() as $email) {
            if (!self::matchesWhitelist($email)) {
                $disallowedEmails[] = $email;
            }
        }

        if (!empty($disallowedEmails)) {
            $event->sender->addError('emails', Yii::t('EnterpriseModule.emailwhitelist', 'The follwing emails do not match the whitelist settings: {emails}', ['emails' => implode(", ", $disallowedEmails)]));
            $event->sender->addError('inviteExternal', Yii::t('EnterpriseModule.emailwhitelist', 'The follwing emails do not match the whitelist settings: {emails}', ['emails' => implode(", ", $disallowedEmails)]));

            $event->isValid = false;
        }
    }

    /**
     * Checks if the current whitelist setting is empty.
     * @return type
     */
    public static function isEmptyWhitelist()
    {
        $form = new WhitelistSettingsForm();
        return empty($form->whitelist);
    }

    /**
     * Checks the given email against the whitelist.
     * To match the whitelist the email must equal or end with one of the whitelist rules.
     * If the whitelist is not set, we return true.
     * 
     * @param type $email
     * @return boolean - true if email matches the whitelist or whitelist not set else false
     */
    public static function matchesWhitelist($email)
    {
        $form = new WhitelistSettingsForm();

        //If the email is empty the form is responsible for validating
        if (empty($form->whitelist) || empty($email)) {
            return true;
        }

        // Add group whitelist / auto assignments to whitelist
        foreach (\humhub\modules\user\models\Group::find()->all() as $group) {
            if ($group->enterprise_email_map != '' && self::matchEmail($group->enterprise_email_map, $email)) {
                return true;
            }
        }

        if (self::matchEmail($form->whitelist, $email)) {
            return true;
        }

        return false;
    }

    public static function onUserInsert($event)
    {
        // Add group whitelist / auto assignments to whitelist
        foreach (\humhub\modules\user\models\Group::find()->all() as $group) {
            if ($group->enterprise_email_map != '' && self::matchEmail($group->enterprise_email_map, $event->sender->email)) {
                $group->addUser($event->sender);
            }
        }
    }

    protected static function matchEmail($list, $email)
    {
        foreach (preg_split('/\r\n|[\r\n]/', $list) as $line) {
            $line = trim($line);
            if ($line == $email || substr($email, -strlen($line)) === $line) {
                return true;
            }
        }

        return false;
    }

}
