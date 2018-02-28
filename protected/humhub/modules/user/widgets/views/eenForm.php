<?php
use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div>
    <?php echo Yii::t("UserModule.widgets_views_eenform_title", "Please Enter your EEN credentials") ?>

    <?php $form = ActiveForm::begin(['action' => ['een/een-validate-form']]); ?>
    <?= $form->field($model, 'emailEen')->label(Yii::t("UserModule.widgets_views_eenform_username", "Username")) ?>
    <?php echo $form->field($model, 'passwordEen')->passwordInput(['id' => 'login_password'])->label(Yii::t("UserModule.widgets_views_eenform_password", "Password")); ?>


    <?php
    echo \humhub\widgets\AjaxButton::widget([
        'label' => Yii::t('UserModule.views_eenform_submit', 'Submit'),
        'ajaxOptions' => [
            'type' => 'POST',
            'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
            'success' => 'function(html){ alert("test OK!");$("#globalModal").html(html); }',
            'url' => Url::to(['/user/een/een-validate-form']),
        ],
        'htmlOptions' => [
            'class' => 'btn btn-success'
        ]
    ]);
    ?>



    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>

</div>
<hr>

