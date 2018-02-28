<?php

namespace humhub\modules\enterprise\modules\spacetype\models;

use Yii;

/**
 * @inheritdoc
 */
class SpaceType extends \humhub\modules\space\models\Space
{

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['changeType'] = ['space_type_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [['space_type_id', 'integer']]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'space_type_id' => Yii::t('EnterpriseModule.spacetype', 'Type'),
        ]);
    }

}
