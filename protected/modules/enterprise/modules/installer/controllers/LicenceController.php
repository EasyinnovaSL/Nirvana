<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\installer\controllers;

use Yii;
use humhub\models\Setting;
use humhub\modules\enterprise\modules\installer\models\LicenceForm;

/**
 * Description of DefaultController
 *
 * @author luke
 */
class LicenceController extends \yii\web\Controller
{

    public function actionIndex()
    {
        
        $licence = Setting::Get('licence', 'enterprise');
        if ($licence != '') {
            Yii::$app->getModule('enterprise')->enable();
            return $this->redirect(Yii::$app->getModule('installer')->getNextConfigStepUrl());
        }
        
        
        $form = new LicenceForm;
        if ($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            Yii::$app->getModule('enterprise')->enable();
            return $this->redirect(Yii::$app->getModule('installer')->getNextConfigStepUrl());
        }

        return $this->render('index', array('model' => $form));
    }

}
