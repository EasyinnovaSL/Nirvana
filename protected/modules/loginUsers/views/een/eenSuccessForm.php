<?php
use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><strong>Innovation Advisor</strong> <?php echo Yii::t("LoginUsersModule.join_the_network", "EEN Credentials")?></h4>
        </div>
        <div class="modal-body">

            <p><?php echo Yii::t("LoginUsersModule.widgets_views_eenform_title", "EEN Credentials stored correctly") ?></p>

            <?php $form = ActiveForm::begin(['action' => ['een/een-validate-form']]); ?>

            <p>EasyPP is a tool that will help you and your client to edit collaboratively a Partner Profile and submit it to the EEN platform.</p>

            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('LoginUsersModule.views_eenform_submit', 'Connect to EasyPP'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => 'function(html){$("#globalModal").html(html); }',
                    'url' => Url::to(['/loginUsers/een/easypp-input-form']),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-success'
                ]
            ]);
            ?>

            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('LoginUsersModule.views_eenform_submit', 'Dismiss'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => 'function(html){$("#globalModal").html(html); }',
                    'url' => Url::to(['/loginUsers/een/easypp-dismiss-form']),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
            ?>

            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Ask later</button>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>