<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use humhub\modules\user\widgets\AuthChoice;
use humhub\modules\user\widgets\EenForm;

?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><strong><?php echo Yii::t("LoginUsersModule.innvators", "An error has ocurred")?></strong></h4>
        </div>
        <div class="modal-body">
            <br/>

                <div class="text-center">
                    <?php echo Yii::t("LoginUsersModule.innvators", "Unable to load login")?>
                </div>
            <br/>

        </div>
    </div>
</div>