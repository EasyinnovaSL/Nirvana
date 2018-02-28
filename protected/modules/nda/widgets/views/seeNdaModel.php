<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
?>

<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <?php echo Html::dropDownList("ndaChooseModelList", "", $nda_models, array('class' => 'form-control')); ?>
    </div>
  </div>
  <div class="col-md-2">
    <?php
      echo \humhub\widgets\AjaxButton::widget([
          'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'See NDA Draft'),
          'ajaxOptions' => [
              'type' => 'POST',
              'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
              'success' => new yii\web\JsExpression('function(html){
                if (typeof html === "object" && html.error) return alert("Url incorrecta");
                //$("#globalModal").html(html); currentStream.showStream(); updateSteps();
                window.open("uploads/" + html);
                }'),
              'url' => $space->createUrl('/nda/nda-model/view-model', array('card_id' => $card_id)),
          ],
          'htmlOptions' => [
              'class' => 'btn btn-primary'
          ]
      ]);
    ?>
  </div>

</div>
