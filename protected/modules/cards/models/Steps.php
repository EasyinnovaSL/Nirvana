<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "steps".
 *
 * @property integer $space_id
 * @property integer $user_id
 * @property string $step
 */
class Steps extends \humhub\modules\content\components\ContentActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'steps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_id', 'user_id'], 'required'],
            [['space_id', 'user_id'], 'integer'],
            [['step'], 'string', 'max' => 45],
            [['space_id', 'user_id'], 'unique', 'targetAttribute' => ['space_id', 'user_id'], 'message' => 'The combination of Space ID and User ID has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'space_id' => 'Space ID',
            'user_id' => 'User ID',
            'step' => 'Step',
        ];
    }
}
