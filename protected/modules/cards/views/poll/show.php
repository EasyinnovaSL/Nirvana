<?php

use yii\bootstrap\ActiveForm;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content poll_content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel"><?= Yii::t("CardsModule.modals", 'Create Poll') ?></h4>
        </div>
        <div class="modal-body">
           <?php echo \humhub\modules\cards\widgets\PollEntryForm::widget([
               'contentContainer' => $contentContainer, 
               'submitButtonText' => Yii::t('PollsModule.widgets_PollFormWidget', 'Ask'),
            ]); ?>

        </div>

    </div>

</div>


<script type="text/javascript">

    jQuery('.poll_content #post_submit_button').click( function () {
        setTimeout(function(){ $("#globalModal").modal('hide') }, 2000);
    })

</script>