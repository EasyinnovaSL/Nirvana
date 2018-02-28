<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "card_content".
 *
 * @property integer $id
 * @property integer $card_id
 * @property integer $content_related_id
 * @property string $tag
 * @property integer $order
 *
 * @property Card $card
 */
class CardContent extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'content_related_id', 'tag'], 'required'],
            [['card_id', 'content_related_id', 'order'], 'integer'],
            [['tag'], 'string', 'max' => 100],
            [['card_id', 'content_related_id'], 'unique', 'targetAttribute' => ['card_id', 'content_related_id'],
                'message' => 'The combination of Card ID and Content Related ID has already been taken.'],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Card::className(), 'targetAttribute' => ['card_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'content_related_id' => 'Content Related ID',
            'tag' => 'Tag',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Card::className(), ['id' => 'card_id']);
    }
}
