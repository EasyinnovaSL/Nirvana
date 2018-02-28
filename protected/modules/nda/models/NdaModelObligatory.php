<?php

namespace humhub\modules\nda\models;

use Yii;
use humhub\modules\space\models\Space;

/**
 * This is the model class for table "nda_model_obligatory".
 *
 * @property integer $id
 * @property integer $nda_model_id
 * @property integer $space_id
 *
 * @property NdaModel $ndaModel
 * @property Space $space
 */
class NdaModelObligatory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nda_model_obligatory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_id'], 'required'],
            [['space_id'], 'integer'],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'space_id' => 'Space ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        return $this->hasOne(Space::className(), ['id' => 'space_id']);
    }
}
