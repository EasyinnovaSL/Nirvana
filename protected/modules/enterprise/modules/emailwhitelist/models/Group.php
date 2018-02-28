<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\emailwhitelist\models;

use Yii;

/**
 * Group model extensions for e-mail mapping
 *
 * @author Luke
 */
class Group extends \humhub\modules\user\models\Group
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['enterprise_email_map', 'string'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['editEmailMap'] = ['enterprise_email_map'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'enterprise_email_map' => Yii::t('EnterpriseModule.emailwhitelist', 'E-Mails'),
        ];
    }

    public function attributeHints()
    {
        return ['enterprise_email_map' => Yii::t('EnterpriseModule.whitelist', 'Separate multiple rules by a new line.')];
    }

}
