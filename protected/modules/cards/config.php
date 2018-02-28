<?php

use humhub\commands\CronController;
use humhub\modules\cards\Module;
use humhub\widgets\TopMenu;
use humhub\modules\user\models\Invite;
use humhub\modules\space\models\Space;
use humhub\modules\space\widgets\Menu;
use humhub\modules\calendar\models\CalendarEntry;
use humhub\components\Widget;
#use humhub\modules\calendar\Module;

return [
    'id' => 'cards',
    'class' => 'humhub\modules\cards\Module',
    'namespace' => 'humhub\modules\cards',
    'events' => [
        ['class' => humhub\modules\content\widgets\WallEntryControls::className(),
            'event' => humhub\modules\content\widgets\WallEntryControls::EVENT_INIT,
            'callback' => ['humhub\modules\cards\Events', 'onWallEntryControlsInit']],

        ['class' => humhub\modules\content\widgets\WallEntryAddons::className(),
            'event' => humhub\modules\content\widgets\WallEntryAddons::EVENT_INIT,
            'callback' => ['humhub\modules\cards\Events', 'onWallEntryAddonsInit']],

        ['class' => humhub\modules\content\widgets\WallEntryControls::className(),
            'event' => humhub\modules\content\widgets\WallEntryControls::EVENT_RUN,
            'callback' => ['humhub\modules\cards\Events', 'onWallEntryControlsInit']],

        ['class' => humhub\modules\content\widgets\WallEntryAddons::className(),
            'event' => humhub\modules\content\widgets\WallEntryAddons::EVENT_RUN,
            'callback' => ['humhub\modules\cards\Events', 'onWallEntryAddonsInit']],

        ['class' => humhub\modules\space\models\Membership::className(),
            'event' => humhub\modules\space\models\Membership::EVENT_AFTER_INSERT,
            'callback' => ['humhub\modules\cards\Events', 'onSpaceMembership']],

        ['class' => 'humhub\modules\space\models\Space', 'event' => Space::EVENT_AFTER_INSERT,
            'callback' => ['humhub\modules\cards\Events', 'onSpaceCreated']],

        ['class' => humhub\modules\space\models\forms\InviteForm::className(),
            'event' => humhub\modules\space\models\forms\InviteForm::EVENT_AFTER_VALIDATE,
            'callback' => ['humhub\modules\cards\controllers\InviteController', 'onInviteInsert']],

        ['class' => Menu::className(),
              'event' => Menu::EVENT_INIT, 
              'callback' => ['humhub\modules\cards\Events', 'onSpaceMenuInit']],


        ['class' => humhub\modules\space\models\forms\InviteForm::className(),
            'event' => humhub\modules\space\models\forms\InviteForm::EVENT_AFTER_VALIDATE,
            'callback' => ['humhub\modules\cards\controllers\InviteController', 'onInviteInsert']],


        ['class' => \humhub\components\Application::className(),
            'event' =>  \humhub\components\Application::EVENT_BEFORE_ACTION,
            'callback' => ['humhub\modules\cards\Events', 'manageEvents']
        ],
        ['class' => CronController::className(), 'event' => CronController::EVENT_ON_DAILY_RUN,
            'callback' => array('humhub\modules\cards\Events', 'onCronDailyRun')
        ],

        ['class' =>humhub\modules\space\models\Membership::className(),
            'event' =>humhub\modules\space\models\Membership::EVENT_AFTER_INSERT,
            'callback' => ['humhub\modules\cards\controllers\InviteController', 'onInviteNotificationSent']],

        /*['class' =>humhub\modules\space\models\Membership::className(),
            'event' =>humhub\modules\space\models\Membership::EVENT_AFTER_UPDATE,
            'callback' => ['humhub\modules\cards\controllers\InviteController', 'onInviteNotificationSent']],*/

        /*['class' => 'humhub\modules\space\widgets\Chooser',
         'event' => Widget::EVENT_CREATE,
         'callback' => ['humhub\modules\cards\Events', 'onSpaceProjectCreate']],*/
    ]
];
?>
