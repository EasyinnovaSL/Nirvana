<?php

namespace humhub\modules\nda\models;

use Yii;
use humhub\modules\nda\models\NdaModel;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;

/**
 * This is the model class for table "nda_agreement".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $nda_model_id
 * @property integer $space_id
 * @property string $status
 *
 * @property User $user
 * @property NdaModel $ndaModel
 * @property Space $space
 */
class NdaAgreement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nda_agreement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'nda_model_id', 'space_id', 'status'], 'required'],
            [['user_id', 'nda_model_id', 'space_id'], 'integer'],
            [['status'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['nda_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => NdaModel::className(), 'targetAttribute' => ['nda_model_id' => 'id']],
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
            'user_id' => 'User ID',
            'nda_model_id' => 'Nda Model ID',
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
    public function getNdaModel()
    {
        return $this->hasOne(NdaModel::className(), ['id' => 'nda_model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        return $this->hasOne(Space::className(), ['id' => 'space_id']);
    }
}
