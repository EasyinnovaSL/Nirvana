<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "user_card".
 *
 * @property integer $user_id
 * @property integer $card_id
 * @property string $card_status
 *
 * @property Card $card
 */
class UserCard extends \humhub\components\ActiveRecord
{
    const STATUS_HOLD           = 'hold';
    const STATUS_PENDING        = 'pending';
    const STATUS_COMPLETED      = 'completed';
    const STATUS_DISMISSED      = 'dismissed';
    const STATUS_ONGOING        = 'ongoing';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'card_id'], 'required'],
            [['user_id', 'card_id'], 'integer'],
            [['card_status'], 'string', 'max' => 10],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Card::className(), 'targetAttribute' => ['card_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'card_id' => 'Card ID',
            'card_status' => 'Card Status',
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
