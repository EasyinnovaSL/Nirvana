<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype\controllers;

use Yii;
use humhub\modules\directory\widgets\Sidebar;
use humhub\modules\enterprise\modules\spacetype\models\Type;
use humhub\models\Setting;

/**
 * DirectoryController
 *
 * @author luke
 */
class DirectoryController extends \humhub\modules\directory\components\Controller
{

    public function actionIndex()
    {
        $spaceType = Type::findOne(['id' => Yii::$app->request->get('id'), 'show_in_directory' => 1]);

        if ($spaceType === null) {
            throw new \yii\web\HttpException(404, 'Could not find space type!');
        }

        $pageSize = Setting::Get('paginationSize');
        if (property_exists(Yii::$app->getModule('directory'), 'pageSize')) {
            $pageSize = Yii::$app->getModule('directory')->pageSize;
        }
        
        $keyword = Yii::$app->request->get('keyword', "");
        $page = (int) Yii::$app->request->get('page', 1);

        $searchResultSet = Yii::$app->search->find($keyword, [
            'model' => \humhub\modules\space\models\Space::className(),
            'page' => $page,
            'sortField' => ($keyword == '') ? 'title' : null,
            'pageSize' => $pageSize,
            'filters' => [
                'type_id' => ($spaceType !== null) ? $spaceType->id : ''
            ]
        ]);

        $pagination = new \yii\data\Pagination(['totalCount' => $searchResultSet->total, 'pageSize' => $searchResultSet->pageSize]);

        \yii\base\Event::on(Sidebar::className(), Sidebar::EVENT_INIT, function($event) {
            $event->sender->addWidget(\humhub\modules\directory\widgets\NewSpaces::className(), [], ['sortOrder' => 10]);
            $event->sender->addWidget(\humhub\modules\directory\widgets\SpaceStatistics::className(), [], ['sortOrder' => 20]);
        });

        return $this->render('index', array(
                    'keyword' => $keyword,
                    'spaces' => $searchResultSet->getResultInstances(),
                    'pagination' => $pagination,
                    'spaceType' => $spaceType
        ));
    }

}
