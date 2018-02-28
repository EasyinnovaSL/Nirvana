<?php

namespace humhub\modules\enterprise\modules\account\widgets;

use Yii;
use humhub\components\Widget;
use humhub\models\Setting;

class Warning extends Widget
{

    const CHECK_INTERVAL = 86400;

    protected $licence;

    public function init()
    {
        $this->licence = Setting::get('licence', 'enterprise');
    }

    public function run()
    {
        // Show unregistered warning for all 
        if ($this->licence == '') {
            $trialDaysLeft = Yii::$app->getModule('enterprise')->getTrialLeftDays();
            if ($trialDaysLeft > 0) {
                if (!Yii::$app->user->isAdmin()) {
                    return;
                }
                // Show remaining days to admins
                return $this->render('warning_trial', ['daysLeft' => $trialDaysLeft]);
            } else {
                return $this->render('warning_unregistered');
            }
        }

        // Do regular check
        $time = Setting::get('last_check', 'enterprise');
        if ($time == "" || time() > $time + self::CHECK_INTERVAL || Setting::get('licence_valid', 'enterprise') != 1) {
            Yii::$app->getModule('enterprise')->checkLicence();
        }

        // Check validity flag
        if (Setting::get('licence_valid', 'enterprise') != 1) {
            return $this->render('warning_invalid');
        }
    }

}

?>