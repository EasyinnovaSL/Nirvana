<?php

namespace humhub\modules\cards\models;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "step_user_space".
 *
 * @property integer $id
 * @property integer $step_id
 * @property integer $user_id
 * @property integer $space_id
 * @property string  $status
 *
 * @property User $user
 * @property Space $space
 * @property Step $step
 */
class StepUserSpace extends \humhub\components\ActiveRecord
{
    const STATUS_HOLD           = 'hold';
    const STATUS_PENDING        = 'pending';
    const STATUS_COMPLETED      = 'completed';
    const STATUS_DISMISSED      = 'dismissed';
    const STATUS_ONGOING        = 'ongoing';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'step_user_space';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['step_id', 'user_id', 'space_id'], 'required'],
            [['step_id', 'user_id', 'space_id'], 'integer'],
            [['status'], 'string', 'max' => 10],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
            [['step_id'], 'exist', 'skipOnError' => true, 'targetClass' => Step::className(), 'targetAttribute' => ['step_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_id' => 'Step ID',
            'user_id' => 'User ID',
            'space_id' => 'Space ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        return $this->hasOne(Space::className(), ['id' => 'space_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStep()
    {
        return $this->hasOne(Step::className(), ['id' => 'step_id']);
    }
}
