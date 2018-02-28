<?php

use humhub\compat\CActiveForm;
use humhub\compat\CHtml;
use humhub\models\Setting;
use yii\helpers\Url;
use humhub\modules\user\models\User;
?>
<div id="name-form" class="panel panel-default animated fadeIn">

    <div class="panel-heading">
        <?php echo Yii::t('EnterpriseModule.installer', 'Enterprise Edition <strong>Licence</strong>'); ?>
    </div>

    <div class="panel-body">
        <p><?php echo Yii::t('EnterpriseModule.installer', 'Please specify your Enterprise Edition Licence Code below, you can also leave it blank to start a 14 days trial.'); ?></p>
        <?php $form = CActiveForm::begin(); ?>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'code'); ?>
        </div>

        <hr>

        <?php echo CHtml::submitButton(Yii::t('base', 'Next'), array('class' => 'btn btn-primary')); ?>

        <?php CActiveForm::end(); ?>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        // set cursor to email field
        $('#LicenseForm_code').focus();
    })

</script>


