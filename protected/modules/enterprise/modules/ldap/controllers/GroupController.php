<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\ldap\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use humhub\modules\admin\components\Controller;

/**
 * Description of GroupController
 *
 * @author luke
 */
class GroupController extends Controller
{

    /**
     * @var \humhub\modules\user\models\Group
     */
    public $group;

    public function init()
    {
        $this->group = \humhub\modules\user\models\Group::findOne(['id' => (int) Yii::$app->request->get('groupId')]);

        if ($this->group === null) {
            throw new \yii\web\HttpException(404, 'Could not load group!');
        }

        $this->subLayout = '@admin/views/layouts/user';
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \humhub\modules\enterprise\modules\ldap\models\Group::find()->where(['group_id' => $this->group->id]),
            'pagination' => ['pageSize' => 50],
        ]);


        $groups = \yii\helpers\ArrayHelper::map(\humhub\modules\user\models\Group::find()->all(), 'id', 'name');
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'groups' => $groups,
                    'group' => $this->group
        ]);
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->get('id');

        $model = null;
        if ($id != '') {
            $model = \humhub\modules\enterprise\modules\ldap\models\Group::findOne(['id' => $id]);
        }

        if ($model === null) {
            $model = new \humhub\modules\enterprise\modules\ldap\models\Group;
        }

        $model->group_id = $this->group->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->redirect(Url::to(['index', 'groupId' => $this->group->id]));
        }

        $groups = \yii\helpers\ArrayHelper::map(\humhub\modules\user\models\Group::find()->all(), 'id', 'name');
        return $this->render('edit', [
                    'model' => $model,
                    'groups' => $groups,
                    'group' => $this->group,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $model = \humhub\modules\enterprise\modules\ldap\models\Group::findOne(['id' => $id]);

        if ($model !== null) {
            $model->delete();
        }

        $this->redirect(['index', 'groupId' => $this->group->id]);
    }

}
