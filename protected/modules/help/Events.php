<?php

namespace humhub\modules\help;

use Yii;

class Events extends \yii\base\Object
{
    public static function onTopMenuRightInit($event)
    {
        $event->sender->addWidget(widgets\InteractiveTutorialButton::className());
    }
}