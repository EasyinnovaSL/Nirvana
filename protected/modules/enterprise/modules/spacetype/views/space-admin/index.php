<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use humhub\modules\space\modules\manage\widgets\DefaultMenu;
?>


<br/>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo Yii::t('EnterpriseModule.spacetype', '<strong>Change</strong> type'); ?></div>
    <?= DefaultMenu::widget(['space' => $space]); ?>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->field($model, 'space_type_id')->dropdownList($spaceTypes); ?>

        <?php echo Html::submitButton(Yii::t('base', 'Save'), array('class' => 'btn btn-primary')); ?>
        <?php echo \humhub\widgets\DataSaved::widget(); ?>

        <?php ActiveForm::end(); ?>
    </div>

</div>


