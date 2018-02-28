<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\installer;

use Yii;
use yii\helpers\Url;

/**
 * Installer
 *
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\enterprise\modules\installer\controllers';

    public function init()
    {
        parent::init();
        $this->layout = '@humhub/modules/installer/views/layouts/main.php';
    }

    public function beforeAction($action)
    {
        // Block installer, when it's marked as installed
        if (Yii::$app->params['installed']) {
            throw new \yii\web\HttpException(500, 'HumHub is already installed!');
        }

        Yii::$app->controller->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public static function onInstallerConfigSteps($event)
    {
        $event->sender->configSteps['licence_key'] = [
            'sort' => 10,
            'url' => Url::to(['/enterprise/installer/licence']),
            'isCurrent' => function() {
        return (Yii::$app->controller->id == 'licence');
    },
        ];
    }

}
