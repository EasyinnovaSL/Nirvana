<?php

use yii\helpers\Html;
?>


<div class="panel panel-danger panel-unregistered">
    <div class="panel-heading"><?php echo Yii::t('EnterpriseModule.account', '<strong>Unregistered</strong> Enterprise Edition'); ?></div>
    <div class="panel-body">
        <p><?php echo Yii::t('EnterpriseModule.account', 'Please register this <strong>HumHub - Enterprise Edition</strong>!'); ?></p>
        <br />
        <?php if (Yii::$app->user->isAdmin()): ?>
            <?php echo Html::a('Register now', ['/enterprise/account/register'], ['class' => 'btn btn-danger']); ?>
        <?php endif; ?>
    </div>
</div>
