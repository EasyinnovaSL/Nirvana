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
 * This is the model class for table "extra_data_user".
 *
 */
class ExtraDataUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'extra_data_user';
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
        return $this->find(\humhub\modules\user\models\Group::className(), ['id' => 'group_id']);
    }

}
