<?php
use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><strong>Innovator</strong> <?php echo Yii::t("LoginUsersModule.join_the_network", "EEN Credentials")?></h4>
        </div>
        <div class="modal-body">
            <p><?php echo Yii::t("LoginUsersModule.widgets_views_eenform_credentials_stored_correctly", "Dismissed EEN connection") ?></p>
        </div>
    </div>
</div>