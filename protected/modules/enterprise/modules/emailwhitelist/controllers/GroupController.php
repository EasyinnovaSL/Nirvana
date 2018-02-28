<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\emailwhitelist\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use humhub\modules\admin\components\Controller;

/**
 * GroupController provides e-mail mapping for group
 *
 * @author luke
 */
class GroupController extends Controller
{

    /**
     * @var \humhub\modules\user\models\Group
     */
    public $group;

    /**
     * @inheritdoc
     */
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

        $group = \humhub\modules\enterprise\modules\emailwhitelist\models\Group::findOne(['id' => $this->group->id]);

        if ($group->load(Yii::$app->request->post()) && $group->save()) {
            Yii::$app->getSession()->setFlash('data-saved', Yii::t('AdminModule.controllers_SettingController', 'Saved'));
        }

        return $this->render('index', [
                    'group' => $group
        ]);
    }

}
