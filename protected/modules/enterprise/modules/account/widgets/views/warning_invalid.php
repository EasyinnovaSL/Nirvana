<?php

use yii\helpers\Html;
?>


<div class="panel panel-danger panel-invalid">
    <div class="panel-heading"><?php echo Yii::t('EnterpriseModule.account', '<strong>Invalid</strong> Enterprise Edition Licence'); ?></div>
    <div class="panel-body">
        <p><?php echo Yii::t('EnterpriseModule.account', 'Please update this <strong>HumHub - Enterprise Edition</strong> licence!'); ?></p>
        <br>
        <?php if (Yii::$app->user->isAdmin()): ?>
            <?php echo Html::a('Update', ['/enterprise/account/register'], ['class' => 'btn btn-danger']); ?>
        <?php endif; ?>
    </div>
</div>