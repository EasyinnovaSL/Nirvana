<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "workflow".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Cards[] $cards
 * @property Cards[] $cards0
 * @property WorkflowSpaceType[] $workflowSpaceTypes
 */
class Workflow extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workflow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Cards::className(), ['workflow_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards0()
    {
        return $this->hasMany(Cards::className(), ['workflow_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflowSpaceTypes()
    {
        return $this->hasMany(WorkflowSpaceType::className(), ['workflow_id' => 'id']);
    }
}
