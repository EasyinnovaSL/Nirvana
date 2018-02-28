<?php

use humhub\components\ActiveRecord;
use humhub\widgets\BaseMenu;
use humhub\modules\space\models\Space;
use humhub\components\Widget;
use humhub\widgets\BaseStack;
use humhub\modules\user\controllers\AuthController;

return [
    'id' => 'enterprise',
    'class' => 'humhub\modules\enterprise\Module',
    'namespace' => 'humhub\modules\enterprise',
    'isInstallerModule' => true,
    'events' => [
        // Email Whitelist
        ['class' => 'humhub\modules\user\models\forms\Registration', 'event' => 'beforeValidate', 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onRegistrationBeforeValidate']],
        ['class' => 'humhub\modules\user\models\Invite', 'event' => ActiveRecord::EVENT_BEFORE_VALIDATE, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onInviteBeforeValidate']],
        ['class' => 'humhub\modules\user\models\forms\Invite', 'event' => ActiveRecord::EVENT_BEFORE_VALIDATE, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onInviteFormBeforeValidate']],
        ['class' => 'humhub\modules\space\models\forms\InviteForm', 'event' => ActiveRecord::EVENT_BEFORE_VALIDATE, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onInviteFormBeforeValidate']],
        ['class' => 'humhub\modules\admin\widgets\AuthenticationMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onAuthenticationMenuInit']],
        ['class' => 'humhub\modules\admin\widgets\UserMenu', 'event' => BaseMenu::EVENT_RUN, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onAdminUserMenuInit']],
        ['class' => 'humhub\modules\admin\widgets\GroupManagerMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onAdminGroupMenuInit']],
        ['class' => 'humhub\modules\user\models\User', 'event' => \yii\db\ActiveRecord::EVENT_AFTER_INSERT, 'callback' => ['humhub\modules\enterprise\modules\emailwhitelist\Module', 'onUserInsert']],
        // Space Type
        ['class' => 'humhub\modules\admin\widgets\SpaceMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onAdminSpaceMenuInit']],
        ['class' => 'humhub\modules\directory\widgets\Menu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onDirectoryMenuInit']],
        ['class' => 'humhub\modules\space\models\Space', 'event' => Space::EVENT_SEARCH_ADD, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onSpaceSearchAdd']],
        ['class' => 'humhub\modules\space\modules\manage\widgets\DefaultMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onSpaceAdminDefaultMenuInit']],
        ['class' => 'humhub\modules\space\models\Space', 'event' => Space::EVENT_BEFORE_INSERT, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onSpaceBeforeInsert']],
        ['class' => 'humhub\modules\space\widgets\Chooser', 'event' => Widget::EVENT_CREATE, 'callback' => ['humhub\modules\enterprise\modules\spacetype\Module', 'onSpaceChooserCreate']],
        // Account
        ['class' => 'humhub\modules\admin\widgets\AdminMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\account\Module', 'onAdminMenuInit']],
        ['class' => 'humhub\modules\dashboard\widgets\Sidebar', 'event' => BaseStack::EVENT_INIT, 'callback' => array('humhub\modules\enterprise\modules\account\Module', 'onDashboardSidebarInit')],
        // Installer
        ['class' => 'humhub\modules\installer\Module', 'event' => \humhub\modules\installer\Module::EVENT_INIT_CONFIG_STEPS, 'callback' => ['humhub\modules\enterprise\modules\installer\Module', 'onInstallerConfigSteps']],
        // LDAP
        ['class' => 'humhub\modules\user\libs\Ldap', 'event' => 'update_user', 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onUpdateUser']],
        ['class' => 'humhub\modules\space\modules\manage\widgets\MemberMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onSpaceMemberMenuInit']],
        ['class' => 'humhub\modules\admin\widgets\GroupManagerMenu', 'event' => BaseMenu::EVENT_INIT, 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onAdminGroupMenuInit']],
        ['class' => 'humhub\modules\user\models\Group', 'event' => yii\db\ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onGroupDelete']],
        ['class' => 'humhub\modules\space\models\Space', 'event' => yii\db\ActiveRecord::EVENT_BEFORE_DELETE, 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onSpaceDelete']],
        ['class' => 'humhub\modules\user\authclient\Collection', 'event' => 'client_set', 'callback' => ['humhub\modules\enterprise\modules\ldap\Module', 'onAuthClientCollectionInit']],
        // JWT
        ['class' => AuthController::className(), 'event' => AuthController::EVENT_BEFORE_ACTION, 'callback' => ['humhub\modules\enterprise\modules\jwt\Module', 'onAuthClientCollectionInit']],
    ],
    'modules' => [
        'account' => [
            'class' => 'humhub\modules\enterprise\modules\account\Module'
        ],
        'spacetype' => [
            'class' => 'humhub\modules\enterprise\modules\spacetype\Module'
        ],
        'installer' => [
            'class' => 'humhub\modules\enterprise\modules\installer\Module'
        ],
        'ldap' => [
            'class' => 'humhub\modules\enterprise\modules\ldap\Module'
        ],
        'solr' => [
            'class' => 'humhub\modules\enterprise\modules\solr\Module'
        ],
        'emailwhitelist' => [
            'class' => 'humhub\modules\enterprise\modules\emailwhitelist\Module'
        ],
        'jwt' => [
            'class' => 'humhub\modules\enterprise\modules\jwt\Module'
        ],
    ],
];
?>