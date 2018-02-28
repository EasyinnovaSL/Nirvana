<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\emailwhitelist\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use \humhub\modules\enterprise\modules\emailwhitelist\models\forms\WhitelistSettingsForm;

/**
 * Whitelist AdminController. Used to define the email whitelist setting, which
 * can restrict allowed emails for invitations and registrations.
 *
 * @author buddha
 */
class AdminController extends Controller
{
    /**
     * Index email whitelist admin action.
     * @return type
     */
    public function actionIndex()
    {
        $form = new WhitelistSettingsForm();
        
        if($form->load(Yii::$app->request->post()) && $form->validate() && $form->save()) {
            Yii::$app->getSession()->setFlash('data-saved', Yii::t('EnterpriseModule.emailwhitelist', 'Saved'));
            return $this->redirect(['/enterprise/emailwhitelist/admin/index']);
        } 
        
        $this->subLayout = '@admin/views/layouts/user';
        return $this->render('index', ['model' => $form]);
    }
    
}
