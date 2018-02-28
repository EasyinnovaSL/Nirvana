<?php

namespace humhub\modules\cards\models;

use Yii;

/**
 * This is the model class for table "cards".
 *
 * @property integer $id
 * @property integer $step_id
 * @property integer $workflow_id
 * @property integer $card_type_id
 * @property string $icon
 * @property string $title
 * @property string $description
 * @property integer $card_parent_id
 * @property integer $related_card
 * @property integer $card_order
 * @property integer $content_required
 * @property integer $card_mandatory
 * @property integer $card_child_related
 * @property integer $hide
 * @property integer $card_skip
 * @property integer $folded
 *
 * @property Card[] $cards
 * @property Cards $cardParent
 * @property Cards[] $cards0
 * @property Cards $relatedCard
 * @property Cards[] $cards1
 * @property CardType $cardType
 * @property Step $step
 * @property Workflow $workflow
 * @property Workflow $workflow0
 */
class Cards extends \humhub\components\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cards';
    }

    /**
     * @inheritdoc
     */
    
    public function rules()
    {
        return [
            [['step_id', 'workflow_id', 'card_type_id', 'card_order'], 'required'],
            [['step_id', 'workflow_id', 'card_type_id', 'card_parent_id', 'related_card', 'card_order', 'content_required', 'card_mandatory', 'card_child_related', 'hide', 'card_skip'], 'integer'],
            [['description'], 'string'],
            [['icon'], 'string', 'max' => 14],
            [['title'], 'string', 'max' => 255],
            [['card_parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['card_parent_id' => 'id']],
            [['related_card'], 'exist', 'skipOnError' => true, 'targetClass' => Cards::className(), 'targetAttribute' => ['related_card' => 'id']],
            [['card_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => CardType::className(), 'targetAttribute' => ['card_type_id' => 'id']],
            [['step_id'], 'exist', 'skipOnError' => true, 'targetClass' => Step::className(), 'targetAttribute' => ['step_id' => 'id']],
            [['workflow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workflow::className(), 'targetAttribute' => ['workflow_id' => 'id']],
            [['workflow_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workflow::className(), 'targetAttribute' => ['workflow_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'step_id' => 'Step ID',
            'workflow_id' => 'Workflow ID',
            'card_type_id' => 'Card Type ID',
            'icon' => 'Icon',
            'title' => 'Title',
            'description' => 'Description',
            'card_parent_id' => 'Card Parent ID',
            'related_card' => 'Related Card',
            'card_order' => 'Card Order',
            'content_required' => 'Content Required',
            'card_mandatory' => 'Card Mandatory',
            'card_child_related' => 'Card Child Related',
            'hide' => 'Hide',
            'card_skip' => 'Card Skip',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards()
    {
        return $this->hasMany(Card::className(), ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardParent()
    {
        return $this->hasOne(Cards::className(), ['id' => 'card_parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards0()
    {
        return $this->hasMany(Cards::className(), ['card_parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedCard()
    {
        return $this->hasOne(Cards::className(), ['id' => 'related_card']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCards1()
    {
        return $this->hasMany(Cards::className(), ['related_card' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardType()
    {
        return $this->hasOne(CardType::className(), ['id' => 'card_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStep()
    {
        return $this->hasOne(Step::className(), ['id' => 'step_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow()
    {
        return $this->hasOne(Workflow::className(), ['id' => 'workflow_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkflow0()
    {
        return $this->hasOne(Workflow::className(), ['id' => 'workflow_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardRestrictions()
    {
        return $this->hasMany(CardRestriction::className(), ['card_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardRestrictions0()
    {
        return $this->hasMany(CardRestriction::className(), ['card_restriction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardRestrictions1()
    {
        return $this->hasMany(CardRestriction::className(), ['card_parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCardRestrictions2()
    {
        return $this->hasMany(CardRestriction::className(), ['related_card' => 'id']);
    }

}
