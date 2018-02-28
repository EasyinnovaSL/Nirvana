<?php

namespace humhub\modules\companies\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $company_linkedin
 * @property string $website
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_linkedin
 * @property string $cooperation_looking_for
 * @property string $missing_info
 * @property string $company_details
 * @property string $advisor_remarks
 *
 * @property CompanyCard[] $companyCards
 * @property CompanySpace[] $companySpaces
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'company_linkedin', 'website', 'contact_name', 'contact_email', 'contact_linkedin'], 'required'],
            [['contact_email'], 'email'],
            [['contact_linkedin', 'company_linkedin', 'website'], 'url'],
            [['cooperation_looking_for', 'missing_info', 'company_details', 'advisor_remarks'], 'string'],
            [['company_name', 'company_linkedin', 'website', 'contact_name', 'contact_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'company_linkedin' => 'Company Linkedin',
            'website' => 'Website',
            'contact_name' => 'Contact Name',
            'contact_email' => 'Contact Email',
            'contact_linkedin' => 'Contact Linkedin',
            'cooperation_looking_for' => 'Cooperation Looking For',
            'missing_info' => 'Missing Info',
            'company_details' => 'Company Details',
            'advisor_remarks' => 'Advisor Remarks',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyCards()
    {
        return $this->hasMany(CompanyCard::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanySpaces()
    {
        return $this->hasMany(CompanySpace::className(), ['company_id' => 'id']);
    }
}
