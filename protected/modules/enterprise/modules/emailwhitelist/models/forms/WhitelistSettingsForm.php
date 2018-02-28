<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\emailwhitelist\models\forms;

use Yii;

/**
 * WhitelistSettingsForm used to define a email whitelist for restricting allowed
 * emails for invitations and registration.
 *
 * @author buddha
 */
class WhitelistSettingsForm extends \yii\base\Model
{
    /**
     * New line seperated list of emails
     * @var type 
     */
    public $whitelist;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [['whitelist', 'trim']];
    }
    
    public function attributeHints()
    {
        return ['whitelist' => Yii::t('EnterpriseModule.whitelist', 'Separate multiple whitelist rules by a new line.')];
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->whitelist = Yii::$app->getModule('enterprise')->settings->get('email.whitelist');
    }
    
    /**
     * Saves the whitelist settings
     * @return boolean
     */
    public function save() 
    {
        Yii::$app->getModule('enterprise')->settings->set('email.whitelist', $this->whitelist);
        return true;
    }
}
