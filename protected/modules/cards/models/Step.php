<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "step".
 *
 * @property integer $id
 * @property integer $workflow_id
 * @property integer $user_role_id
 * @property string $step_name
 * @property integer $step_order
 *
 * @property Cards[] $cards
 * @property StepUserSpace[] $stepUserSpaces
 */
class Step extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'step';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id', 'step_order'], 'required'],
            [['workflow_id', 'user_role_id', 'step_order'], 'integer'],
            [['step_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'workflow_id' => 'Workflow ID',
            'user_role_id' => 'User Role ID',
            'step_name' => 'Step Name',
            'step_order' => 'Step Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Cards::className(), ['step_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStepUserSpaces()
    {
        return $this->hasMany(StepUserSpace::className(), ['step_id' => 'id']);
    }
}
