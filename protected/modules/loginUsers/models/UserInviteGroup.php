<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\loginUsers\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "user_invite_group".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_invite_id
 * @property integer $space_role_id
 */
class UserInviteGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_invite_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }


    /**
     * Return Group which is involved in this invite user table
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(\humhub\modules\user\models\Group::className(), ['id' => 'group_id']);
    }

    /**
     * Return Group which is involved in this invite user table
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserInvite()
    {
        return $this->hasOne(\humhub\modules\user\models\Invite::className(), ['id' => 'user_invite_id']);
    }

}
