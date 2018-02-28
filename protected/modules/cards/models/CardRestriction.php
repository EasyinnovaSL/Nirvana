<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "card_restriction".
 *
 * @property integer $id
 * @property integer $card_id
 * @property integer $card_restriction_id
 *
 * @property Cards $card
 * @property Cards $cardRestriction
 */
class CardRestriction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card_restriction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['card_id', 'card_restriction_id'], 'required'],
            [['card_id', 'card_restriction_id'], 'integer'],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['card_id' => 'id']],
            [['card_restriction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['card_restriction_id' => 'id']],
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
            'card_restriction_id' => 'Card Restriction ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(Cards::className(), ['id' => 'card_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardRestriction()
    {
        return $this->hasOne(Cards::className(), ['id' => 'card_restriction_id']);
    }
}
