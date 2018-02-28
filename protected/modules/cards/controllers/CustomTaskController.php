<?php

namespace humhub\modules\cards\controllers;

use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;

/**
 * Default controller for the `example` module
 */
class CustomTaskController extends ContentContainerController
{

    /**
     * Shows the questions tab
     */
    public function actionCreate()
    {
        return $this->renderAjax('show', array(
            'contentContainer' => $this->contentContainer
        ));
    }

}
