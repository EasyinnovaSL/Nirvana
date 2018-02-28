<?php

namespace humhub\modules\cards\models;

use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "space_user_role".
 *
 * @property integer $space_id
 * @property integer $user_id
 * @property integer $user_role_id
 *
 * @property Space $space
 * @property User $user
 * @property UserRole $userRole
 */
class SpaceUserRole extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'space_user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['space_id', 'user_id', 'user_role_id'], 'required'],
            [['space_id', 'user_id', 'user_role_id'], 'integer'],
            [['space_id', 'user_id', 'user_role_id'], 'unique', 'targetAttribute' => ['space_id', 'user_id', 'user_role_id'],
                'message' => 'The combination of Space ID, User ID and User Role ID has already been taken.'],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRole::className(), 'targetAttribute' => ['user_role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'space_id' => 'Space ID',
            'user_id' => 'User ID',
            'user_role_id' => 'User Role ID',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRole()
    {
        return $this->hasOne(UserRole::className(), ['id' => 'user_role_id']);
    }
}
