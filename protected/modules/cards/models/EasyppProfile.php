<?php

/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 27/01/2017
 * Time: 8:50
 */

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "easypp_profile".
 *
 * @property integer $space_id
 * @property string $profile
 */
class EasyppProfile extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easypp_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['space_id'], 'integer'],
            [['profile'], 'string', 'max' => 100],
            [['online'], 'boolean'],
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
            'profile' => 'Profile',
            'online' => 'Online',
        ];
    }
}
