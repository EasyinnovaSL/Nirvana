<?php

use humhub\widgets\NotificationArea;
use humhub\modules\help\Events;

return [
    'id' => 'help',
    'class' => 'humhub\modules\help\Module',
    'namespace' => 'humhub\modules\help',
    'events' => [
        ['class' => NotificationArea::className(), 'event' => NotificationArea::EVENT_INIT, 'callback' => array( 'humhub\modules\help\Events', 'onTopMenuRightInit')],
    ]
    ];
?>
