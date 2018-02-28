<?php

namespace humhub\modules\enterprise;

use Yii;
use humhub\models\Setting;

class Module extends \humhub\components\Module
{

    /**
     * @var boolean recursivly lookup ldap resolve group memberships
     */
    public $enableLdapParentMembershipLookup = false;

    const TRIAL_DAYS = 0xE;

    public function disable()
    {
        // Switch back to HumHub Default Theme
        if (Setting::Get('theme') == 'enterprise') {
            Setting::Set('theme', 'HumHub');
            \humhub\libs\DynamicConfig::rewrite();
        }

        parent::disable();
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer === null) {
            $permissions = [];


            // Return SpaceType 
            foreach (modules\spacetype\models\Type::find()->all() as $spaceType) {
                $permissions[] = new modules\spacetype\permissions\CreateSpaceType(['spaceType' => $spaceType]);
            }

            return $permissions;
        }

        return [];
    }

    public function checkLicence()
    {
        $licence = Setting::get('licence', 'enterprise');

        // No Licence Key given
        if ($licence == '') {
            return;
        }

        $result = \humhub\modules\admin\libs\HumHubAPI::request('v1/enterprise/register', ['licence' => $licence]);
        if (!isset($result['status'])) {
            // Api Problem
            return;
        } elseif ($result['status'] != 'ok') {
            // Not valid
            Setting::set('licence_valid', 0, 'enterprise');
        } else {
            // Valid
            Setting::set('licence_valid', 1, 'enterprise');
        }

        Setting::set('last_check', time(), 'enterprise');
    }

    public function getTrialLeftDays()
    {
        $trialStart = Setting::get('trial_start', 'enterprise');
        if ($trialStart == '') {
            $trialStart = time();
            Setting::set('trial_start', $trialStart, 'enterprise');
        }

        return ceil((($trialStart + (self::TRIAL_DAYS * 86400)) - time()) / 86400);
    }

}
