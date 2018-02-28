<?php

namespace  humhub\modules\companies\models;

use humhub\modules\space\models\Space;
use Yii;

/**
 * This is the model class for table "nir_related".
 *
 * @property integer $id
 * @property integer $id_space_pre_nir
 * @property integer $id_space_nir
 *
 * @property Space $idSpaceNir
 * @property Space $idSpacePreNir
 */
class NirRelated extends \humhub\components\ActiveRecord
{
        /**
     * @inheritdoc
     */
    public static function tableName()
    {
            return 'nir_related';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
            return [
                [[ 'id_space_pre_nir', 'id_space_nir'], 'required'],
            [[ 'id_space_pre_nir', 'id_space_nir'], 'integer'],
            [['id_space_nir'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['id_space_nir' => 'id']],
            [['id_space_pre_nir'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['id_space_pre_nir' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
            return [
                'id' => 'ID',
            'id_space_pre_nir' => 'Id Space Pre Nir',
            'id_space_nir' => 'Id Space Nir',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSpaceNir()
    {
            return $this->hasOne(Space::className(), ['id' => 'id_space_nir']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSpacePreNir()
    {
            return $this->hasOne(Space::className(), ['id' => 'id_space_pre_nir']);
    }
}
