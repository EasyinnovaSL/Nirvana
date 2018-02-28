<?php

use humhub\compat\CActiveForm;
use yii\helpers\Html;
?>
<div class="modal-dialog modal-dialog-small animated fadeIn">
    <div class="modal-content poll_content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?= Yii::t("CompaniesModule.modals", 'Create Networking Innovation Room (NIR)') ?></h4>
        </div>
        <?php
        $form = CActiveForm::begin();
        $idForm = $form->getId();
        ?>
        <div class="modal-body">

            <div class="form-group">
                <?php echo $form->labelEx($space, 'name'); ?>
                <?php echo $form->textField($space, 'name', array('class' => 'form-control')); ?>

                <?php echo $form->error($space, 'name', array('class' => 'help-block')); ?>
            </div>
        </div>

        <div class="modal-footer">
            <?php
            echo \humhub\widgets\AjaxButton::widget([
                'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
                'ajaxOptions' => [
                    'type' => 'POST',
                    'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                    'success' => new yii\web\JsExpression('function(html){
                	    location.reload();
                	 }'),
                    'url' => $contentContainer->createUrl('/companies/nir/create', array(
                        'card_id' => $card_id, 'company_id' => $company_id, 'space_id' => $space_id )),
                ],
                'htmlOptions' => [
                    'class' => 'btn btn-primary hidden'
                ]
            ]);
            ?>

            <?php echo \humhub\widgets\LoaderWidget::widget(['id' => 'invite-loader', 'cssClass' => 'loader-modal hidden']); ?>
        </div>
        <?php CActiveForm::end(); ?>
        <div class="modal-footer">
            <hr>
            <br>
            <button onclick="checkValidator()" class="btn btn-primary"><?php echo Yii::t('UserModule.views_profile_cropProfileImage', 'Save') ?></button>
        </div>
    </div>

</div>


<script type="text/javascript">

    $( document ).ready(function() {
        $("#Space_name").val($("ul .active a div .media-body").text().replace(/\s/g,'')+"_nir");
    });
    function checkValidator(){
        var textCheck=$("#Space_name").val().toLowerCase();
        var repe=false;
        $('#space-menu-dropdown .media-body').each(function(i, obj) {
            var actual=obj.innerText.replace(/\s/g,'').toLowerCase();
            if(textCheck==actual){
                repe=true;
            }
        });
        if(repe){
            $('#Space_name').parent().find('.help-block').text('<?php echo Yii::t('UserModule.views_profile_cropProfileImage', 'The name is already taken or the spelling is incorrect. Please try another one.') ?>');
            $('#Space_name').parent().find('.help-block').css('cssText', 'color: red !important;');
        }else{
            $("#<?php echo $idForm; ?>").find('button').click();
        }
    }


</script>