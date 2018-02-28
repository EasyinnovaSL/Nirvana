<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype;

use Yii;
use yii\helpers\Url;
use humhub\modules\enterprise\modules\spacetype\models\Type;

/**
 * Space Types
 *
 * @author Luke
 */
class Module extends \humhub\components\Module
{

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'humhub\modules\enterprise\modules\spacetype\controllers';

    public static function onAdminSpaceMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => Yii::t('EnterpriseModule.spacetype', 'Types'),
            'sortOrder' => 300,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'spacetype' && Yii::$app->controller->id == 'admin'),
            'url' => Url::to(['/enterprise/spacetype/admin/index']),
        ));
    }

    public static function onDirectoryMenuInit($event)
    {
        $event->sender->deleteItemByUrl(Url::to(['/directory/directory/spaces']));

        $i = 0;
        foreach (Type::findAll(['show_in_directory' => 1]) as $type) {
            $i++;
            $event->sender->addItem(array(
                'label' => $type->title,
                'sortOrder' => 300 + $i,
                'group' => 'directory',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'spacetype' && Yii::$app->controller->id == 'directory' && Yii::$app->request->get('id') == $type->id),
                'url' => Url::to(['/enterprise/spacetype/directory/index', 'id' => $type->id]),
            ));
        }
    }

    public static function onSpaceAdminDefaultMenuInit($event)
    {
        if (Type::find()->count() > 1) {
            $event->sender->addItem(array(
                'label' => Yii::t('EnterpriseModule.spacetype', 'Type'),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->id == 'space-admin'),
                'url' => $event->sender->space->createUrl('/enterprise/spacetype/space-admin/index'),
            ));
        }
    }

    /**
     * Add type_id to attributes
     */
    public static function onSpaceSearchAdd($event)
    {
        $event->attributes['type_id'] = $event->sender->space_type_id;
    }

    public static function onSpaceBeforeInsert($event)
    {
        $space = $event->sender;

        if ($space->space_type_id == "") {
            $type = Type::find()->orderBy(['sort_key' => SORT_ASC])->one();
            $space->space_type_id = $type->id;
        }
    }

    public static function onSpaceChooserCreate($event)
    {
        // Switch to Enterprise Space Chooser
        $event->config['class'] = widgets\Chooser::className();
    }

}
