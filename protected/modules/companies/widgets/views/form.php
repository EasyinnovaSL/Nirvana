<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>


<div id="globalModalCompany">
  <div class="panel-body">
        <?php
        $form = ActiveForm::begin();
        ?>

          <div class="row">
            <div class="col-md-11">
              <?php
                echo humhub\modules\companies\widgets\CompanyPicker::widget([
                  'model' => $model,
                  'form' => $form
                ]);
              ?>
            </div>
            <div class="col-md-1">
              <a href="https://www.linkedin.com/vsearch/c?type=companies" target="_blank" id="linkedin-company" style="font-size: 30px; margin-top: 19px; display: block; color:#0077B5;"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
            </div>
          </div>

          <?php echo $form->field($model, 'company_linkedin')->textInput(); ?>

          <?php echo $form->field($model, 'website')->textInput(); ?>

          <div class="row">
            <div class="col-md-11">
              <?php echo $form->field($model, 'contact_name')->textInput(); ?>
            </div>
            <div class="col-md-1">
              <a href="https://www.linkedin.com/vsearch/p?type=people" target="_blank" id="linkedin-people" style="font-size: 30px; margin-top: 19px; display: block; color:#0077B5;"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
            </div>
          </div>

          <?php echo $form->field($model, 'contact_email')->textInput(); ?>

          <?php echo $form->field($model, 'contact_linkedin')->textInput(); ?>

          <?php echo $form->field($model, 'cooperation_looking_for')->textarea(['rows' => '3']); ?>

          <?php echo $form->field($model, 'missing_info')->textarea(['rows' => '3']); ?>

          <?php echo $form->field($model, 'company_details')->textarea(['rows' => '3']); ?>

          <?php echo $form->field($model, 'advisor_remarks')->textarea(['rows' => '3']); ?>

          <?php echo Html::hiddenInput('card_id', $card_id); ?>


          <hr />
          <br />
          <?php
          echo \humhub\widgets\AjaxButton::widget([
              'label' => Yii::t('SpaceModule.views_create_create', 'Add'),
              'ajaxOptions' => [
                  'type' => 'POST',
                  'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                  'success' => new yii\web\JsExpression('function(html){ $("#globalModalCompany").html(html);  currentStream.showStream(); updateSteps(); }'),
                  'url' => Url::to(['/companies/form/create', 'space_id' => $space->id]),
              ],
              'htmlOptions' => [
                  'class' => 'btn btn-primary',
                  'id' => 'company-form-create-submit-button',
              ]
          ]);
          ?>

          <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'create-loader', 'cssClass' => 'loader-modal hidden']); ?>
        <?php ActiveForm::end(); ?>
  </div>
</div>

<script type="text/javascript">
  $( "#company-company_name" ).keyup(function() {
    $('#linkedin-company').attr('href', updateQueryStringParameter($('#linkedin-company').attr('href'), 'keywords', $(this).val()))
  });

  $( "#company-contact_name" ).keyup(function() {
    $('#linkedin-people').attr('href', updateQueryStringParameter($('#linkedin-people').attr('href'), 'keywords', $(this).val()))
  });

  function updateQueryStringParameter(uri, key, value) {
     var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
      var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    }else {
       return uri + separator + key + "=" + value;
    }
  }
</script>
