<?php
/**
 * View to edit a link category.
 *
 * @uses $link the link object.
 * @uses $isCreated true if the link is first created, false if an existing link is edited
 *
 * @author Sebastian Stumpf
 *
 */

use humhub\compat\CActiveForm;
use yii\helpers\Html;
?>
<div style="display:none;">
    <?php
    $form = CActiveForm::begin();
    //echo $form->errorSummary($link);
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($link, 'href', array('label' => Yii::t('CardsModule.getSharePPlinkURL', 'EasyPP link for the innovator'))); ?>
        <?php echo $form->textField($link, 'href', array('class' => 'form-control')); ?>
        <?php echo $form->error($link, 'href'); ?>
    </div>

        <?php
        echo \humhub\widgets\AjaxButton::widget([
            'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Share EasyPP link'),
            'ajaxOptions' => [
                'type' => 'POST',
                'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                'success' => new yii\web\JsExpression('function(html){
               		if (typeof html === "object" && html.error) return alert("Invalid URL");
                	$("#globalModal").html(html); currentStream.showStream(); updateSteps();
                	 }'),
                'url' => $space->createUrl('/cards/link/create', array('card_id' => $card_id)),
            ],
            'htmlOptions' => [
                'class' => 'btn btn-primary btn-save-easypp-link'
            ]
        ]);
        ?>
        <?php CActiveForm::end(); ?>
</div>
