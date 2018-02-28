<?php

namespace humhub\modules\cards;
use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\cards\controllers\CalendarController;
use humhub\modules\cards\widgets\CardExtend;
use humhub\modules\content\widgets\WallEntryAddons;
use Yii;
use yii\base\Event;

/**
 * example module definition class
 */

class Module extends \humhub\components\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\cards\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here

    }
}
