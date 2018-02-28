<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\account\controllers;

use humhub\models\Setting;

/**
 * Description of DefaultController
 *
 * @author luke
 */
class DefaultController extends \humhub\modules\admin\components\Controller
{

    public function actionIndex()
    {
        $licenceKey = \humhub\models\Setting::get('licence', 'enterprise');

        $result = \humhub\modules\admin\libs\HumHubAPI::request('v1/enterprise/register', ['licence' => $licenceKey]);

        if (!isset($result['status'])) {
            throw new \yii\web\HttpException("500", 'Could not establish API Connection!');
        } elseif ($result['status'] != 'ok') {
            Setting::set('licence_valid', 0, 'enterprise');
            return $this->redirect(['/enterprise/account/register']);
        }

        return $this->render('index', ['manageUrl' => $result['manageUrl']]);
    }

}
