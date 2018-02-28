<?php

namespace humhub\modules\nda\models;

use Yii;
use humhub\modules\space\models\Space;
use humhub\modules\nda\models\NdaModel;

/**
 * This is the model class for table "nda_model_chose".
 *
 * @property integer $id
 * @property integer $space_id
 * @property integer $nda_model_id
 *
 * @property Space $space
 * @property NdaModel $ndaModel
 */
class NdaModelChoose extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nda_model_chose';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_id', 'nda_model_id'], 'required'],
            [['space_id', 'nda_model_id'], 'integer'],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
            [['nda_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => NdaModel::className(), 'targetAttribute' => ['nda_model_id' => 'id']],
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
            'nda_model_id' => 'Nda Model ID',
        ];
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
    public function getNda_model()
    {
        return $this->hasOne(NdaModel::className(), ['id' => 'nda_model_id']);
    }
}
