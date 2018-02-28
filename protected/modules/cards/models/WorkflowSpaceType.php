<?php

namespace humhub\modules\cards\models;

use humhub\modules\enterprise\modules\spacetype\models\SpaceType;
use Yii;

/**
 * This is the model class for table "workflow_space_type".
 *
 * @property integer $workflow_id
 * @property integer $space_type_id
 *
 * @property SpaceType $spaceType
 * @property Workflow $workflow
 */
class WorkflowSpaceType extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow_space_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['workflow_id', 'space_type_id'], 'required'],
            [['workflow_id', 'space_type_id'], 'integer'],
            [['space_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpaceType::className(), 'targetAttribute' => ['space_type_id' => 'id']],
            [['workflow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workflow::className(), 'targetAttribute' => ['workflow_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'workflow_id' => 'Workflow ID',
            'space_type_id' => 'Space Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpaceType()
    {
        return $this->hasOne(SpaceType::className(), ['id' => 'space_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::className(), ['id' => 'workflow_id']);
    }
}
