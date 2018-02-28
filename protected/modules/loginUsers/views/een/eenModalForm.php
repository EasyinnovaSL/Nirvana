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
            <p><?php echo Yii::t("LoginUsersModule.widgets_views_eenform_title", "Please Enter your EEN credentials, if you want to login on the EEN platform automatically") ?></p>

            <?php if(isset($errorOnValidate) && $errorOnValidate){?>
                <div style="color: #fc4a64; margin-bottom: 5px;">
                    <?php echo Yii::t("LoginUsersModule.widgets_views_eenform_error", "An <strong>Error</strong> has occurred trying to validate your credentials. Please try it again.") ?>
                </div>
            <?php }?>

            <?php $form = ActiveForm::begin(['action' => ['een/een-validate-form']]); ?>
            <?= $form->field($model, 'emailEen')->label(Yii::t("LoginUsersModule.widgets_views_eenform_username", "Username")) ?>
            <?php echo $form->field($model, 'passwordEen')->passwordInput(['id' => 'login_password'])->label(Yii::t("LoginUsersModule.widgets_views_eenform_password", "Password")); ?>


            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('LoginUsersModule.views_eenform_submit', 'Submit'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => 'function(html){$("#globalModal").html(html); }',
                    'url' => Url::to(['/loginUsers/een/een-validate-form']),
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
                    'url' => Url::to(['/loginUsers/een/een-dismiss-form']),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
            ?>

            <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Ask later</button>

            <p class="margin-top10"><?php echo Yii::t("LoginUsersModule.widgets_views_eenform_title", "If you dismiss, you will never be requested again to provide the credentials") ?></p>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>