<?php

switch ($option) {
    case 20:
      echo \humhub\modules\nda\widgets\NdaModelObligatorySave::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    case 21:
      echo \humhub\modules\nda\widgets\ChooseNdaModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    case 22:
      //echo \humhub\modules\nda\widgets\Form::widget(['contentContainer' => $contentContainer, 'card' => $card, 'card_id' => $card->id]);
      echo \humhub\modules\nda\widgets\Form::widget(array('contentContainer' => $contentContainer, 'card_id' => $card->id));
      break;
    case 23:
      echo \humhub\modules\nda\widgets\ConfirmNdaModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    case 24:
      echo \humhub\modules\nda\widgets\SignNdaModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    case 25:
      echo \humhub\modules\nda\widgets\NdaAgreementModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    ////////////////////////////////////////////////////////////
    case 26:
      echo \humhub\modules\nda\widgets\SeeNdaModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
      break;
    //case 27:
    //  echo \humhub\modules\nda\widgets\Form::widget(array('contentContainer' => $contentContainer, 'card_id' => $card->id));
    //  break;
    //case 28:
    //  echo \humhub\modules\nda\widgets\SignNdaModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
    //  break;
    //case 29:
    //  echo \humhub\modules\nda\widgets\NdaAgreementModel::widget(['space' => $contentContainer, 'card_id' => $card->id]);
    //  break;




    /*case 25:
      echo \humhub\modules\nda\widgets\Form::widget(array('contentContainer' => $contentContainer, 'card_id' => $card->id, 'submitUrl' => '/nda/post-task/post'));
      break;*/

}
