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
 * This is the model class for table "easypp_links".
 *
 * @property integer $space_id
 * @property string $profile
 */
class EasyppLinks extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'easypp_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['space_id'], 'integer'],
            [['advisor_link'], 'string', 'max' => 250],
            [['innovator_link'], 'string', 'max' => 250],
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
            'advisor_link' => 'Advisor Link',
            'innovator_link' => 'Innovator Link',
        ];
    }
}
