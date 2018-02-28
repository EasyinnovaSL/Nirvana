<?php

use humhub\modules\companies\Module;
use humhub\modules\companies\Events;
use humhub\modules\space\widgets\Menu;

return [
    'id' => 'companies',
    'class' => 'humhub\modules\companies\Module',
    'namespace' => 'humhub\modules\companies',
    'events' => [
        ['class' => \humhub\components\Application::className(),
            'event' =>  \humhub\components\Application::EVENT_BEFORE_ACTION,
            'callback' => ['humhub\modules\companies\Events', 'manageEvents']
        ]
    ]
];
?>
