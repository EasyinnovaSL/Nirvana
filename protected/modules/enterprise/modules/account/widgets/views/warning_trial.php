<?php

use yii\helpers\Html;
?>


<div class="panel ">
    <div class="panel-heading"><?php echo Yii::t('EnterpriseModule.account', '<strong>Enterprise Edition</strong> Trial Period'); ?></div>
    <div class="panel-body">
        <p><?php echo Yii::t('EnterpriseModule.account', 'You have <strong>{daysLeft}</strong> days left in your trial period.', ['{daysLeft}' => $daysLeft]); ?></p>
        <br>
        <?php echo Html::a('Register', ['/enterprise/account/register'], ['class' => 'btn btn-primary']); ?>
    </div>
</div>
