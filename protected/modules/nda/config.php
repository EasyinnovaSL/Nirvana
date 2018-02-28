<?php

use humhub\modules\companies\Module;
use humhub\modules\companies\Events;
use humhub\modules\space\widgets\Menu;

return [
    'id' => 'nda',
    'class' => 'humhub\modules\nda\Module',
    'namespace' => 'humhub\modules\nda',
    'events' => [
        ['class' => \humhub\components\Application::className(),
            'event' =>  \humhub\components\Application::EVENT_BEFORE_ACTION,
            'callback' => ['humhub\modules\nda\Events', 'manageEvents']
        ]
    ]
];
?>
