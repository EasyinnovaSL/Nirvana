<?php

use humhub\compat\CActiveForm;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content poll_content">
        <div class="modal-header">
            <button id="closeModalCros" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?= Yii::t("CompaniesModule.modals", 'Company reject') ?></h4>
        </div>
        <?php
        $form = CActiveForm::begin();
        $idForm = $form->getId();
        ?>
        <div class="modal-body">

            <span class="col-sm-3 control-label" style="font-weight: bold;padding-right: 0px;padding-left: 0px;padding-top: 8px;font-weight: bold;">Reject reason:</span>
            <textarea type="text" rows="5" value="<?php echo $reason; ?>" id="reject-reason" class="form-control" style="margin-bottom: 5px;" maxlength="254"></textarea>
            <p><?= Yii::t("CompaniesModule.modals", '*Please note the rejection details will reach your advisor, the proposed partner and their advisor (if any)') ?></p>

        </div>
        <?php CActiveForm::end(); ?>
        <div class="modal-footer">
            <hr>
            <br>
            <button onclick="checkValidator(<?php echo $card_id ?>)" class="btn btn-primary">
                <?php echo Yii::t('UserModule.views_profile_cropProfileImage', 'Save') ?>
            </button>
            <button onclick="cancel()" class="btn btn-primary">
                <?php echo Yii::t('UserModule.views_profile_cropProfileImage', 'Cancel') ?>
            </button>
        </div>
    </div>

</div>


<script type="text/javascript">

    function checkValidator(){
        var xhttp = new XMLHttpRequest();
        reason=encodeURI("&sguid=<?php echo $_GET['sguid']; ?>&reason="+$('#reject-reason').val());
        hrefOLD="<?php echo $space->createUrl('/companies/nir/dismis',array('space_id' => $space_id, 'company_id' => $company_id)); ?>";
        hrefNEW=hrefOLD+reason;
        $.ajax({
            type: "POST",
            url: hrefNEW,
            data: {"company_id": "<?php echo $space_id ?>", "company_id": "<?php echo $company_id?>", "reason": encodeURI($('#reject-reason').val())},
            success:function( data ) {
                $("#closeModalCros").click();
            }
        });
    }
    function  cancel() {
        $("#closeModalCros").click();
    }

</script>