<?php

use yii\web\View;

    $resultList = '';

    if(!empty($cardInteractiveTutorialState)) {

     $cardInteractiveTutorialState->intereractive_tutorial_json = str_replace("#CARD_ID_#", $childCard->id,$cardInteractiveTutorialState->intereractive_tutorial_json);

     $resultList = $cardInteractiveTutorialState->intereractive_tutorial_json;
    }

$jsCardChild =<<<JS
    var newStepForCard = null;
    newStepForCard = [{$resultList}];

    steps_for_card_id_{$card->id} = $.merge(steps_for_card_id_{$card->id}, newStepForCard);
JS;

$this->registerJS($jsCardChild, View::POS_END);

?>


