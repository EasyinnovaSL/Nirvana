<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\account\controllers;

use Yii;
use humhub\models\Setting;
use humhub\modules\enterprise\modules\installer\models\LicenceForm;

/**
 * Description of DefaultController
 *
 * @author luke
 */
class RegisterController extends \humhub\modules\admin\components\Controller
{

    public function actionIndex()
    {
        $model = new LicenceForm;
        $model->code = Setting::Get('licence', 'enterprise');

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->render('thank_you');
        }

        return $this->render('index', ['model' => $model]);
    }

}
