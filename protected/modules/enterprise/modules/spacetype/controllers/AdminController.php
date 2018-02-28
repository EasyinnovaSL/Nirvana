<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype\controllers;

use Yii;
use yii\web\HttpException;
use humhub\modules\admin\components\Controller;
use humhub\modules\space\models\Space;
use humhub\modules\enterprise\modules\spacetype\models\Type;
use humhub\modules\enterprise\modules\spacetype\models\SpaceTypeDelete;
use humhub\modules\enterprise\modules\spacetype\models\SpaceTypeSearch;

/**
 * Description of AdminController
 *
 * @author luke
 */
class AdminController extends Controller
{

    /**
     * Lists all created space types
     */
    public function actionIndex()
    {

        $searchModel = new SpaceTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', array(
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel
        ));
    }

    /**
     * Edit/Create a space type
     */
    public function actionEdit()
    {
        $type = Type::findOne(['id' => Yii::$app->request->get('id')]);
        if ($type === null) {
            $type = new Type();
            $type->show_in_directory = 1;
            $type->sort_key = 100;
        }

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            $type->save();
            return $this->redirect(['index']);
        }

        return $this->render('edit', array(
                    'type' => $type,
                    'canDelete' => $this->canDeleteSpaceType()
        ));
    }

    /**
     * Delete a space type
     */
    public function actionDelete()
    {
        if (!$this->canDeleteSpaceType()) {
            throw new HttpException(500, 'Could not delete space type!');
        }

        $type = Type::findOne(['id' => Yii::$app->request->get('id')]);
        if ($type === null) {
            throw new \yii\web\HttpException(404, 'Could not find space type!');
        }

        $model = new SpaceTypeDelete();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            foreach (Space::find()->where(['space_type_id' => $type->id])->all() as $space) {
                $space->space_type_id = $model->space_type_id;
                $space->save();
            }
            $type->delete();
            return $this->redirect(['index']);
        }

        $alternativeTypes = \yii\helpers\ArrayHelper::map(Type::find()->where(['!=', 'id', $type->id])->all(), 'id', 'title');

        return $this->render('delete', array(
                    'type' => $type,
                    'model' => $model,
                    'alternativeTypes' => $alternativeTypes
        ));
    }

    /**
     * Checks if a space type can deleted
     * 
     * @return boolean
     */
    private function canDeleteSpaceType()
    {
        return (Type::find()->count() > 1);
    }

}
