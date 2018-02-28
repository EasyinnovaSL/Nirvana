<?php

namespace humhub\modules\help\widgets;

use Yii;
use humhub\modules\help\models\CardsInteractiveTutorialState;


class InteractiveTutorialCardButton extends \yii\base\Widget
{
    public $contentContainer;
    public $card;

    public function run()
    {
        if (!Yii::$app->user->isGuest){

            $existInteractiveTutorialForCard = CardsInteractiveTutorialState::find()->where(array('cards_id' => $this->card->card_id, 'language' => Yii::$app->language,'state' => $this->card->getStatus()->card_status))->one();

            if(!empty($existInteractiveTutorialForCard)){
                return $this->render('interactiveTutorialCardButton', array(
                    'contentContainer' => $this->contentContainer,
                    'card' => $this->card,
                    'cardInteractiveTutorialState' => $existInteractiveTutorialForCard
                ));
            }
        }
    }

}
