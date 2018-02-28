<?php

use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t("CardsModule.modals", 'Create Meeting') ?></h4>
        </div>
        <div class="modal-body">
           <?php echo \humhub\modules\cards\widgets\MeetingEntryForm::widget([
               'contentContainer' => $contentContainer, 
               'submitButtonText' => 'Ok',
            ]); ?>

        </div>

    </div>

</div>


<script type="text/javascript">


</script>