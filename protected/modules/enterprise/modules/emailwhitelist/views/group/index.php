<?php

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\widgets\GridView;
use humhub\widgets\ActiveForm;
?>

<?php $this->beginContent('@admin/views/group/_manageLayout.php', ['group' => $group]) ?>
<div class="panel-body">
    <p />

    <div class="help-block">
        <?= Yii::t('EnterpriseModule.emailwhitelist', 'The email mapping allows you to specify email rules for users which will be automatically assigned to this group after registration.'); ?><br /><br />
        <?= Yii::t('EnterpriseModule.emailwhitelist', 'A rule can either be in the form @example.com to allow each email of the given host or a complete address as user@example.com'); ?><br />
        <?= Yii::t('EnterpriseModule.emailwhitelist', 'When the E-Mail Whitelist feature is also enabled (at least one rule) - the given rules will be also added to the whitelist.'); ?>
    </div>


    <?php $form = ActiveForm::begin([]) ?>
    <?= $form->field($group, 'enterprise_email_map')->textarea(['id' => 'enterprise_email_map-ta', 'rows' => 12])->label(false); ?>

    <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
    <?php echo \humhub\widgets\DataSaved::widget(); ?>
    <?php ActiveForm::end() ?>

</div>
<?php $this->endContent(); ?>

<script type="text/javascript">
    $('#enterprise_email_map-ta').autosize();
</script>

