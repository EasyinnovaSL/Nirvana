<?php

namespace humhub\modules\user\models\forms;

use Yii;
use yii\helpers\Url;
use humhub\modules\user\models\User;

/**
 * @package humhub.modules_core.user.forms
 * @author Jordi
 */
class EenValidateForm extends \yii\base\Model
{


    public $emailEen;
    public $passwordEen;


    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('passwordEen', 'required'),
            array('emailEen', 'required'),
        );
    }


}
