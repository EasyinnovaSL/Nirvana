<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\help\widgets;

use Yii;
use humhub\modules\help\models\CardsInteractiveTutorialState;


/**
 * InteractiveTutorialButton Widget for TopMenu
 */
class InteractiveTutorialLoadChildCardJson extends \yii\base\Widget
{

    public $contentContainer;
    public $card;
    public $childCard;
    public $childCardStatus;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest){
            $existInteractiveTutorialForFatherCard = CardsInteractiveTutorialState::find()->where(array('cards_id' => $this->card->card_id, 'language' => Yii::$app->language,  'state' => $this->card->getStatus()->card_status))->one();

            if(!empty($existInteractiveTutorialForFatherCard)) {

                $existInteractiveTutorialForChildCard =
                    CardsInteractiveTutorialState::find()
                        ->where(array('cards_id' => $this->childCard->card_id,
                            'state' => $this->childCard->getStatus()->card_status))->one();

                if (!empty($existInteractiveTutorialForChildCard)) {
                    return $this->render('interactiveTutorialLoadChildCardJson', array(
                        'contentContainer' => $this->contentContainer,
                        'card' => $this->card,
                        'childCard' => $this->childCard,
                        'childCardStatus' => $this->childCardStatus,
                        'cardInteractiveTutorialState' => $existInteractiveTutorialForChildCard
                    ));
                }

            }
        }
    }

}
