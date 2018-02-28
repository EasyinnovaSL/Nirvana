<?php

namespace humhub\modules\enterprise\modules\installer\models;

use Yii;
use humhub\models\Setting;

/**
 * ConfigBasicForm holds basic application settings.
 *
 * @package humhub.modules_core.installer.forms
 * @since 0.5
 */
class LicenceForm extends \yii\base\Model
{

    public $code;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('code', 'validateCode'),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'code' => Yii::t('EnterpriseModule.installer', 'Licence Serial Code'),
        );
    }

    public function validateCode($attribute)
    {
        if ($this->code != "") {
            $result = \humhub\modules\admin\libs\HumHubAPI::request('v1/enterprise/register', ['licence' => $this->code]);

            if (!isset($result['status'])) {
                $this->addError('code', 'API Connection failed!');
            } elseif ($result['status'] != 'ok') {
                $this->addError('code', 'Invalid Licence Key!');
            }
        }
        
    }

    public function save()
    {
        // Register HumHub Installation with installationId and Serial
        Setting::Set('licence', $this->code, 'enterprise');
        Setting::set('last_check', time(), 'enterprise');
        Setting::set('licence_valid', 1, 'enterprise');
        
        return true;
    }

}
