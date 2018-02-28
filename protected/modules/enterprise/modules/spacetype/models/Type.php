<?php

namespace humhub\modules\enterprise\modules\spacetype\models;

use Yii;

/**
 * This is the model class for table "space_type".
 *
 * @property integer $id
 * @property string $title
 * @property string $item_title
 * @property integer $sort_key
 * @property integer $show_in_directory
 */
class Type extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'space_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'item_title', 'sort_key'], 'required'],
            [['sort_key', 'show_in_directory'], 'integer'],
            [['title', 'item_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('SpaceModule.models_Type', 'ID'),
            'title' => Yii::t('SpaceModule.models_Type', 'Title'),
            'item_title' => Yii::t('SpaceModule.models_Type', 'Item Title'),
            'sort_key' => Yii::t('SpaceModule.models_Type', 'Sortorder'),
            'show_in_directory' => Yii::t('SpaceModule.models_Type', 'Show In Directory'),
        ];
    }

    /**
     * Checks if current user can a space of this type
     */
    public function getCreateSpacePermission()
    {
        $permission = new \humhub\modules\enterprise\modules\spacetype\permissions\CreateSpaceType();
        $permission->spaceType = $this;
        return $permission;
    }

    public function canCreateSpace()
    {
        if (Yii::$app->user->isAdmin()) {
            return true;
        }

        return (Yii::$app->user->permissionManager->can($this->getCreateSpacePermission()));
    }

}
