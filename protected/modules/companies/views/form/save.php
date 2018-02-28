<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="panel-body">
    <h4><strong><?= Yii::t("CompaniesModule.modals", 'Company') ?></strong> <?= Yii::t("CompaniesModule.modals", 'shared successfull') ?>
        <?php echo \humhub\widgets\DataSaved::widget(); ?></h4>
</div>
