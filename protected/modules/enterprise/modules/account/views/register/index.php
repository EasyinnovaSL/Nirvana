<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>

<div class="panel panel-danger">
    <div
        class="panel-heading"><?php echo Yii::t('EnterpriseModule.account', '<strong>Register</strong> Enterprise Edition'); ?></div>
    <div class="panel-body">
        <?php echo Yii::t('EnterpriseModule.account', "Please enter your <strong>HumHub - Enterprise Edition</strong> licence key below. If you don't have a licence key yet, you can obtain one at %link%.", ['%link%' => Html::a('https://www.humhub.org/enterprise', 'https://www.humhub.org/enterprise', ['target' => '_blank', 'class' => 'colorInfo'])]); ?>

        <br>
        <br>
        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
        <?php echo $form->field($model, 'code'); ?>

        <hr>

        <?php echo Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-loader' => "modal", 'data-message' => Yii::t('EnterpriseModule.account', 'Validating...')]); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>
