<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="panel panel-default">
    <div
        class="panel-heading"><?php echo Yii::t('EnterpriseModule.spacetype', '<strong>Delete</strong> space type'); ?></div>
    <div class="panel-body">

        <p>
            <?php echo Yii::t('EnterpriseModule.spacetype', 'To delete the space type <strong>"{type}"</strong> you need to set an alternative type for existing spaces:', array('{type}' => Html::encode($type->title))); ?>
        </p>
        <?php
        $form = ActiveForm::begin([])
        ?>
        <?= $form->field($model, 'space_type_id')->dropDownList($alternativeTypes) ?>

        <?= Html::submitButton(Yii::t('base', 'Delete'), ['class' => 'btn btn-danger']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>




