<?php

use yii\helpers\Html;
Html::a(
    '<i class="fa fa-plus-close"></i> Cerrar y Archivar ',
    $contentContainer->createUrl(
        '/companies/nir/close-nir',
        array('card_id' => $card_id, 'space_id' => $contentContainer->id)),
    array('class' => 'btn btn-primary', 'data-target' => '#globalModal')
);
?>

<?php

echo \humhub\widgets\AjaxButton::widget([
    'label' => Yii::t('UserModule.views_profile_cropProfileImage', 'Save'),
    'ajaxOptions' => [
        'type' => 'GET',
        'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
        'success' => new yii\web\JsExpression('function(html){s
                	location.reload();
                	 }'),
        'url' => $contentContainer->createUrl( '/companies/nir/close-nir',
        array('card_id' => $card_id, 'space_id' => $contentContainer->id)),
    ],
    'htmlOptions' => [
        'class' => 'btn btn-primary'
    ]
]);
?>
