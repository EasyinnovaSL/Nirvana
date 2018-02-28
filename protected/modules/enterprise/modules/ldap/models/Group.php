<?php

namespace humhub\modules\enterprise\modules\ldap\models;

use Yii;

/**
 * This is the model class for table "enterprise_ldap_group".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $dn
 */
class Group extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enterprise_ldap_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'dn'], 'required'],
            [['group_id'], 'integer'],
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
            'group_id' => Yii::t('EnterpriseModule.ldap', 'Group'),
            'dn' => Yii::t('EnterpriseModule.ldap', 'LDAP DN'),
        ];
    }

    public function getGroup()
    {
        return $this->hasOne(\humhub\modules\user\models\Group::className(), ['id' => 'group_id']);
    }

}
