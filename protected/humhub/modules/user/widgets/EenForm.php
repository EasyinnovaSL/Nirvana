<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\widgets;

use Yii;
use yii\base\Widget;
use \humhub\modules\user\models\forms\EenValidateForm;

/**
 * EenForm Widget
 *
 * @author Jordi
 */
class EenForm extends Widget
{

    //public $template = "@humhub/modules/user/widgets/views/eenForm";

    public function init()
    {

    }

    public function run()
    {
        $model = new EenValidateForm();

        return $this->render('eenForm', array('model' => $model));
    }

}
