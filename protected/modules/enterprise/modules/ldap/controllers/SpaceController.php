<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\ldap\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use humhub\modules\space\modules\manage\components\Controller;

/**
 * Space Controller
 *
 * @author luke
 */
class SpaceController extends Controller
{

    public function init()
    {
        if (!Yii::$app->user->isAdmin()) {
            throw new \yii\web\HttpException(400, 'Access denied!');
        }

        return parent::init();
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \humhub\modules\enterprise\modules\ldap\models\Space::find()->where(['space_id' => $this->contentContainer->id]),
            'pagination' => ['pageSize' => 50],
        ]);


        return $this->render('index', [
                    'space' => $this->contentContainer,
                    'dataProvider' => $dataProvider
        ]);
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        $model = null;
        if ($id != '') {
            $model = \humhub\modules\enterprise\modules\ldap\models\Space::findOne([
                        'id' => $id,
                        'space_id' => $this->contentContainer->id
            ]);
        }

        if ($model === null) {
            $model = new \humhub\modules\enterprise\modules\ldap\models\Space;
            $model->space_id = $this->contentContainer->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->redirect($this->contentContainer->createUrl('index'));
        }

        return $this->render('edit', ['model' => $model, 'space' => $this->contentContainer]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $model = \humhub\modules\enterprise\modules\ldap\models\Space::findOne([
                    'id' => $id,
                    'space_id' => $this->contentContainer->id
        ]);

        if ($model !== null) {
            $model->delete();
        }

        $this->redirect($this->contentContainer->createUrl('index'));
    }

}
