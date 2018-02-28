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

<?php

if($advisor_role->user_role_id == 3){
    echo Yii::t('UserModule.views_profile_cropProfileImage', 'Observer');
}else if($advisor_role->user_role_id == 4) {
    echo Yii::t('UserModule.views_profile_cropProfileImage', 'Full participant');
}

if ($canChange) {
    $form = CActiveForm::begin();
    echo $form->radioButton($advisor_role,
        'user_role_id',
        array('value' => 3, 'uncheckValue' => null, 'checked' => ($advisor_role->user_role_id == 3),
            'disabled' => !$canChange));
    echo Yii::t('UserModule.views_profile_cropProfileImage', 'Observer');

    echo $form->radioButton($advisor_role,
        'user_role_id',
        array('value' => 4, 'uncheckValue' => null, 'checked' => ($advisor_role->user_role_id == 4),
            'disabled' => !$canChange));
    echo Yii::t('UserModule.views_profile_cropProfileImage', ' Full participant');

    echo \humhub\widgets\AjaxButton::widget([
        'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
        'ajaxOptions' => [
            'type' => 'POST',
            'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
            'success' => new yii\web\JsExpression('function(html){
                	$("#globalModal").html(html); currentStream.showStream(); updateSteps();
                	 }'),
            'url' => $contentContainer->createUrl('/companies/nir/update-advisor', array(
                'space_id' => $advisor_role->space_id,
                'card_id' => $card_id,
                'user_id' => $advisor_role->user_id)),
        ],
        'htmlOptions' => [
            'class' => 'btn btn-primary'
        ]
    ]);

    CActiveForm::end();
}
 ?>