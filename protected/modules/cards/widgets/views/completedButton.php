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
$form = CActiveForm::begin(['options' => ['class' => 'form-dismiss']]);
//echo $form->errorSummary($link);
?>

<?php

	echo \humhub\widgets\AjaxButton::widget([
		'label' => Yii::t("CardsModule.buttons", 'Done'),
		'ajaxOptions' => [
			'type' => 'POST',
			'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
			'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); currentStream.showStream(); updateSteps();}'),
			'url' => $contentContainer->createUrl('/cards/card/completed', array('card_id' => $card->id)),
		],
		'htmlOptions' => [
			'class' => 'btn-completed'
		]
	]);

?>

<?php CActiveForm::end(); ?>
