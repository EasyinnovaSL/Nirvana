<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t("CompaniesModule.modals", 'Select Room to Add Company') ?></h4>
        </div>
        <div class="modal-body">

            <?php $form = ActiveForm::begin(); ?>
            <?php echo \humhub\modules\companies\widgets\SelectNirOptions::widget(array(
                'show_go'   => false,
                'contentContainer'     => $contentContainer
            )) ?>

            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('SpaceModule.views_create_create', 'Submit'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){ }'),
                    'url' => Url::to(['/companies/nir/add-to', 'space_id' => $contentContainer->id]),
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

</div>


<script type="text/javascript">


</script>