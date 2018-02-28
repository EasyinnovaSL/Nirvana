<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
?>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <?php echo Html::dropDownList("ndaConfirmModelList", ($ndaModelChoose) ? $ndaModelChoose->nda_model_id : '', $nda_models, array('class' => 'form-control', 'disabled' =>  ($ndaModelConfirmExist) ? true : false)); ?>
    </div>
  </div>
  <div class="col-md-2">
    <?php
      if($ndaModelConfirmExist == null){
        echo \humhub\widgets\AjaxButton::widget([
            'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Confirm NDA Model'),
            'ajaxOptions' => [
                'type' => 'POST',
                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                'success' => new yii\web\JsExpression('function(html){
                  if (typeof html === "object" && html.error) return alert("Url incorrecta");
                  currentStream.showStream();
                   }'),
                'url' => $space->createUrl('/nda/nda-model/confirm', array('card_id' => $card_id, 'space_id' => $space->id)),
            ],
            'htmlOptions' => [
                'class' => 'btn btn-primary'
            ]
        ]);
      }
    ?>
  </div>
  <div class="col-md-2">

  </div>
</div>
