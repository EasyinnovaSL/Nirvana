<?php

namespace humhub\modules\companies\models;

use Yii;

/**
 * This is the model class for table "space_type_relationship".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $category_name
 * @property string $category_related
 */
class SpaceTypeRelationship extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'space_type_relationship';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_name', 'category_related'], 'required'],
            [['category_id'], 'integer'],
            [['category_name'], 'string', 'max' => 45],
            [['category_related'], 'string', 'max' => 7],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'category_related' => 'Category Related',
        ];
    }
}
