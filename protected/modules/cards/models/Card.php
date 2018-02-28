<?php

namespace humhub\modules\cards\models;

use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\libs\DbDateValidator;
use humhub\modules\space\models\Space;
use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $id
 * @property integer $space_id
 * @property integer $card_id
 * @property string $card_end_date
 * @property integer $hide
 *
 * @property Cards $card
 * @property Space $space
 * @property CardContent[] $cardContents
 * @property UserCard[] $userCards
 */
class Card extends ContentActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_EDIT_HIDE = 'edit_hide';

    public $autoAddToWall = true;
    public $wallEntryClass = '\humhub\modules\cards\widgets\CardSimple';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }


    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['card_end_date'],
            self::SCENARIO_EDIT_HIDE => ['edit_hide']
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hide'], 'required', 'on' => self::SCENARIO_EDIT_HIDE],
            [['space_id', 'card_id', 'card_end_date'], 'required'],
            [['space_id', 'card_id', 'hide'], 'integer'],
            [['card_end_date'],  DbDateValidator::className(), 'format' => Yii::$app->params['formatter']['defaultDateFormat']],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['card_id' => 'id']],
            [['space_id'], 'exist', 'skipOnError' => true, 'targetClass' => Space::className(), 'targetAttribute' => ['space_id' => 'id']],
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
            'card_id' => 'Card ID',
            'card_end_date' => 'Card End Date',
            'hide' => 'Hide',
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
    public function getSpace()
    {
        return $this->hasOne(Space::className(), ['id' => 'space_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardContents()
    {
        return $this->hasMany(CardContent::className(), ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCards()
    {
        return $this->hasMany(UserCard::className(), ['card_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getContentName()
    {
        return "";
    }

    /**
     * @inheritdoc
     */
    public function getContentDescription()
    {
        return "";
    }

    public function getChilds() {
        return Card::find()->leftJoin('cards', 'card.card_id=cards.id')
            ->where(array('space_id' => $this->space_id,
                'card_parent_id' => $this->getCard()->one()->id))->all();
    }

    public function getChildsMandatory() {
        return Card::find()->leftJoin('cards', 'card.card_id=cards.id')
            ->where(array('space_id' => $this->space_id, 'card_mandatory' => 1,
                'card_parent_id' => $this->getCard()->one()->id))->all();
    }



    /**
     * @return null|self
     */
    public function getParentCard() {
        return Card::find()->leftJoin('cards', 'card.card_id=cards.id')
            ->where(array('space_id' => $this->space_id,
                'cards.id' => $this->getCard()->one()->card_parent_id))->one();
    }

    public function getRelatedCards() {
        return Card::find()
			->leftJoin('cards', 'card.card_id=cards.id')
            ->where(array('space_id' => $this->space_id,
                'related_card' => $this->getCard()->one()->id))->all();
    }

    public function getStatus() {

        return \humhub\modules\cards\models\UserCard::findOne(array('card_id' => $this->id));
    }

	public function getChildRelated() {
		return Card::find()->leftJoin('cards', 'card.card_id=cards.id')
			->where(array(
				'space_id' => $this->space_id,
				'card_id' => $this->getCard()->one()->card_child_related
			))->all();
	}

    public function getRelatedHideCards() {
        return Card::find()
            ->leftJoin('cards', 'card.card_id=cards.id')
            ->leftJoin('card_restriction', 'card.card_id=card_restriction.card_id')
            ->where(array('space_id' => $this->space_id, 'card_restriction.card_restriction_id' => $this->getCard()->one()->id))->all();
      }

    public static function updateHideCard($card_related)
    {
        $card_r = Card::findOne(['id' => $card_related->id]);
        if($card_r->hide == 1){
          $card_r->hide = 0;
        }else{
          $card_r->hide = 1;
        }
        $card_r->scenario = 'edit_hide';
        $card_r->update();
    }
}
