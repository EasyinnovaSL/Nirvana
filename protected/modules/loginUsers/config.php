<?php

use humhub\modules\loginUsers\Module;
use humhub\modules\companies\Events;
use humhub\modules\space\widgets\Menu;
use humhub\widgets\TopMenu;
use humhub\components\Widget;
use humhub\modules\user\widgets\AccountTopMenu;

return [
    'id' => 'loginUsers',
    'class' => 'humhub\modules\loginUsers\Module',
    'namespace' => 'humhub\modules\loginUsers',
   /* 'events' => [
        ['class' => AccountTopMenu::className(),
         'event' =>   AccountTopMenu::EVENT_RUN,
         'callback' => ['humhub\modules\loginUsers\Events', 'onAccountTopMenuRun']
        ],
    ]*/
];
?>
