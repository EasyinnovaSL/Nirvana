<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "user_role_workflow".
 *
 * @property integer $id
 * @property integer $user_role_id
 * @property integer $workflow_id
 * @property integer $default
 */
class UserRoleWorkflow extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role_workflow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_role_id', 'workflow_id'], 'required'],
            [['id', 'user_role_id', 'workflow_id', 'default'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_role_id' => 'User Role ID',
            'workflow_id' => 'Workflow ID',
            'default' => 'Default',
        ];
    }
}
