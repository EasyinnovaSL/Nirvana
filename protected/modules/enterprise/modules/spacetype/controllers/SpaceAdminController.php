<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype\controllers;

use Yii;
use yii\base\Event;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\space\modules\manage\widgets\Menu;
use humhub\modules\enterprise\modules\spacetype\models\Type;

/**
 * Description of AdminController
 *
 * @author luke
 */
class SpaceAdminController extends ContentContainerController
{

    public $hideSidebar = true;

    public function actionIndex()
    {
        // Highlight correct menu item
        Event::on(Menu::className(), Menu::EVENT_INIT, function ($event) {
            if ($event->sender->space->id == $this->contentContainer->id) {
                $event->sender->markAsActive($this->contentContainer->createUrl('/space/manage'));
            }
        });

        $spaceTypes = \yii\helpers\ArrayHelper::map(Type::find()->all(), 'id', 'item_title');

        $model = \humhub\modules\enterprise\modules\spacetype\models\SpaceType::findOne(['id' => $this->contentContainer->id]);
        $model->scenario = 'changeType';
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('data-saved', Yii::t('base', 'Saved'));
            return $this->redirect($model->createUrl('index'));
        }

        return $this->render('index', ['space' => $this->contentContainer, 'model' => $model, 'spaceTypes' => $spaceTypes]);
    }

}
