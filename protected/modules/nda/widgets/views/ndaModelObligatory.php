<?php
  use yii\helpers\Html;
  use yii\helpers\Url;
  use yii\widgets\ActiveForm;
?>

<style>
  .radio-role-advisor {
    margin: 20px 0px 20px 0px;
  }
</style>

<div class="clearfix radio-role-advisor">

    <?php
      $name = "ndaModelObligatory";
      $items = [0 => "No", 1 => "Yes"];


      echo Html::radioList($name, $ndaModelObligatory, $items, [
          'item' => function ($index, $label, $name, $checked, $value) {
              $disabled = false; // replace with whatever check you use for each item
              return Html::radio($name, $checked, [
                  'value' => $value,
                  'label' => Html::encode($label),
                  'disabled' => $disabled,
              ]);
          },
      ]);
    ?>

</div>

<div class="card-footer">
  <?php
    echo \humhub\widgets\AjaxButton::widget([
        'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
        'ajaxOptions' => [
            'type' => 'POST',
            'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
            'success' => new yii\web\JsExpression('function(html){
              if (typeof html === "object" && html.error) return alert("Url incorrecta");
              $("#globalModal").html(html); currentStream.showStream();
               }'),
            'url' => $space->createUrl('/nda/nda-model/obligatory', array('card_id' => $card_id, 'space_id' => $space->id)),
        ],
        'htmlOptions' => [
            'class' => 'btn btn-primary'
        ]
    ]);
  ?>
</div>
