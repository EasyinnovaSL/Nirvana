<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Munoz
 * Date: 21/02/2017
 * Time: 9:28
 */

use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><strong>Innovation Advisor</strong> <?php echo Yii::t("LoginUsersModule.join_the_network", "EasyPP Credentials")?></h4>
        </div>
        <div class="modal-body">
            <p><?php echo Yii::t("LoginUsersModule.widgets_views_eenform_credentials_stored_correctly", "EasyPP Credentials Stored correctly!") ?></p>
        </div>
    </div>
</div>