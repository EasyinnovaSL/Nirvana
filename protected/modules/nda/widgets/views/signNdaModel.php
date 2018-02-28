<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\widgets\ActiveForm;
?>

<div class="card-footer">
  <?php

    if(is_null($modelIsSigned)){
      echo \humhub\widgets\AjaxButton::widget([
          'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Sign Model'),
          'ajaxOptions' => [
              'type' => 'POST',
              'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
              'success' => new yii\web\JsExpression('function(html){
                if (typeof html === "object" && html.error) return alert("Url incorrecta");
                  currentStream.showStream(); updateSteps();
                 }'),
              'url' => $space->createUrl('/nda/nda-model/sign', array('card_id' => $card_id, 'space_id' => $space->id)),
          ],
          'htmlOptions' => [
              'class' => 'btn btn-primary'
          ]
      ]);
    }

  ?>
</div>
