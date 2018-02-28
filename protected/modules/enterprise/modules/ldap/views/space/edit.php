<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\modules\space\modules\manage\widgets\MemberMenu;
?>

<?= MemberMenu::widget(['space' => $space]); ?>
<br />
<div class="panel panel-default">
    <?php if (!$model->isNewRecord) : ?>
        <div
            class="panel-heading"><?php echo Yii::t('EnterpriseModule.ldap', '<strong>Edit</strong> ldap mapping'); ?></div>
        <?php else: ?>
        <div
            class="panel-heading"><?php echo Yii::t('EnterpriseModule.ldap', '<strong>Create</strong> new ldap mapping'); ?></div>
        <?php endif; ?>

    <div class="panel-body">
        <?php $form = ActiveForm::begin([]) ?>
        <?= $form->field($model, 'dn') ?>

        <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary']) ?>

        <?php if (!$model->isNewRecord): ?>
            <?= Html::a(Yii::t('base', 'Delete'), $space->createUrl('delete', ['id' => $model->id]), array('class' => 'btn btn-danger')); ?>
        <?php endif; ?>

        <?php ActiveForm::end() ?>

    </div>
</div>