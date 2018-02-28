<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\account;

use Yii;
use yii\helpers\Url;
use humhub\modules\enterprise\modules\spacetype\models\Type;
use humhub\models\Setting;

/**
 * Account
 *
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\enterprise\modules\account\controllers';

    public static function onAdminMenuInit($event)
    {

        if (Setting::Get('licence', 'enterprise') != null && Setting::Get('licence_valid', 'enterprise') == 1) {
            $statusIcon = ' <i class="fa fa-check-circle colorSuccess"></i>';
        } else {
            $statusIcon = ' <i class="fa fa-warning colorDanger"></i>';
        }

        $event->sender->addItem(array(
            'label' => Yii::t('EnterpriseModule.account', 'Enterprise Edition'). $statusIcon,
            'icon' => '<i class="fa fa-briefcase"></i>',
            'group' => 'settings',
            'sortOrder' => 110,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'account'),
            'url' => Url::to(['/enterprise/account/default/index']),
        ));
    }

    public static function onDashboardSidebarInit($event)
    {
        //$event->sender->addWidget(widgets\Warning::className(), array(), array('sortOrder' => 0));
    }

}
