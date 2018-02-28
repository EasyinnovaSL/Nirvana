<?php

namespace humhub\modules\enterprise\modules\ldap\models;

use Yii;

/**
 * This is the model class for table "enterprise_ldap_space".
 *
 * @property integer $id
 * @property integer $space_id
 * @property string $dn
 */
class Space extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enterprise_ldap_space';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_id', 'dn'], 'required'],
            [['space_id'], 'integer'],
            [['dn'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('EnterpriseModule.ldap', 'ID'),
            'space_id' => Yii::t('EnterpriseModule.ldap', 'Space ID'),
            'dn' => Yii::t('EnterpriseModule.ldap', 'LDAP DN'),
        ];
    }

    public function getSpace()
    {
        return $this->hasOne(\humhub\modules\space\models\Space::className(), ['id' => 'space_id']);
    }

}
