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
use humhub\modules\cards\models\UserCard;
use yii\helpers\Html;
?>

<?php
$form = CActiveForm::begin(['options' => ['class' => 'form-dismiss']]);
//echo $form->errorSummary($link);
?>

<?php
if (!$mandatory && $card->getStatus() && $card->getStatus()->card_status == UserCard::STATUS_PENDING) {
	echo \humhub\widgets\AjaxButton::widget([
		'label' => Yii::t("CardsModule.buttons", 'Dismiss'),
		'ajaxOptions' => [
			'type' => 'POST',
			'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
			'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); currentStream.showStream(); updateSteps();}'),
			'url' => $contentContainer->createUrl('/cards/card/dismiss', array('card_id' => $card->id)),
		],
		'htmlOptions' => [
			'class' => $styleClass
		]
	]);
/*} elseif ($card->getStatus() && $card->getStatus()->card_status == UserCard::STATUS_DISMISSED) {
	echo \humhub\widgets\AjaxButton::widget([
		'label' => Yii::t("CardsModule.buttons", 'UnDismiss'),
		'ajaxOptions' => [
			'type' => 'POST',
			'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
			'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); currentStream.showStream();}'),
			'url' => $contentContainer->createUrl('/cards/card/un-dismiss', array('card_id' => $card->id)),
		],
		'htmlOptions' => [
			'class' => 'btn btn-danger dismiss'
		]
	]);*/
}
?>

<?php CActiveForm::end(); ?>
