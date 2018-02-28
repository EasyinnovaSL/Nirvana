<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\companies\controllers;

use Yii;
use humhub\modules\companies\controllers\CreateController;
use humhub\modules\enterprise\modules\spacetype\models\Type;

/**
 * CreateSpaceController
 *
 * @author luke
 */
class CreateSpaceController extends CreateController
{

    /**
     * @inheritdoc
     */
    protected function createSpaceModel()
    {
        /*$type = Type::findOne(['id' => Yii::$app->request->get('type_id')]);
        if ($type === null) {
            throw new \yii\base\Exception("Could not find space type!");
        }

        if (!$type->canCreateSpace()) {
            throw new \yii\base\Exception("Insuffient permissions!");
        }*/


        $model = parent::createSpaceModel();
        //$model->space_type_id = $type->id;
        return $model;
    }

    public function getTypeTitle($model)
    {
        $type = Type::findOne(['id' => $model->space_type_id]);
        if ($type !== null) {
            return $type->item_title;
        }

        return "undefined";
    }

}
