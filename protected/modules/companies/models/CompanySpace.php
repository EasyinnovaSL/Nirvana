<?php

namespace humhub\modules\companies\models;

use humhub\modules\space\models\Space;
use Yii;
use humhub\modules\companies\models\Company;

/**
 * This is the model class for table "company_space".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $space_id
 * @property integer $status
 *
 * @property Company $company
 * @property Space $space
 */
class CompanySpace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_space';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'space_id'], 'required'],
            [['company_id', 'space_id', 'status', 'submitted'], 'integer'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
            [['reason'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'space_id' => 'Space ID',
            'status' => 'Nir Status',
            'submitted' => 'Submitted',
            'reason' => 'Reason reject',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpace()
    {
        return $this->hasOne(Space::className(), ['id' => 'space_id']);
    }
}
