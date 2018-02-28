<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<?php $this->beginContent('@admin/views/group/_manageLayout.php', ['group' => $group]) ?>
<div class="panel-body">
    <?php if (!$model->isNewRecord) : ?>
        <h1><?php echo Yii::t('EnterpriseModule.ldap', '<strong>Edit</strong> ldap mapping'); ?></h1>
    <?php else: ?>
        <h1><?php echo Yii::t('EnterpriseModule.ldap', '<strong>Create</strong> new ldap mapping'); ?></h1>
    <?php endif; ?>
    <br />

    <?php $form = ActiveForm::begin([]) ?>
    <?= $form->field($model, 'dn') ?>

    <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= Html::a(Yii::t('base', 'Delete'), Url::to(['delete', 'id' => $model->id]), array('class' => 'btn btn-danger')); ?>
    <?php endif; ?>

    <?php ActiveForm::end() ?>

</div>
<?php $this->endContent(); ?>