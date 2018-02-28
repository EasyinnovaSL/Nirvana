<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use humhub\compat\CActiveForm;
use humhub\modules\calendar\models\CalendarEntry;

?>


<?php $form = CActiveForm::begin(); ?>
<div class="modal-dialog modal-dialog-normal animated fadeIn">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><?= Yii::t("CardsModule.modals", 'Modify date') ?></h4>
		</div>
		<div class="modal-body">

			<?php echo $form->errorSummary($card); ?>
			<div class="row">
				<div class="col-md-6">
					<?php echo $form->field($card, 'card_end_date')->widget(DatePicker::className(), [
						'dateFormat' => Yii::$app->params['formatter']['defaultDateFormat'],
						'clientOptions' => [],
						'options' => ['class' => 'form-control']
					]); ?>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col-md-8 text-left">
					<?php
					echo \humhub\widgets\AjaxButton::widget([
						'label' => Yii::t('CalendarModule.views_entry_edit', 'Save'),
						'ajaxOptions' => [
							'type' => 'POST',
							'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
							'success' => new yii\web\JsExpression('function(html){ $("#globalModal").html(html); }'),
							'url' => $contentContainer->createUrl('/cards/card/submitdeadline', ['card_id' => $card->id]),
						],
						'htmlOptions' => ['class' => 'btn btn-primary']
					]);
					?>
					<button type="button" class="btn btn-primary" data-dismiss="modal">
						<?php echo Yii::t('CalendarModule.views_entry_edit', 'Close'); ?>
					</button>
				</div>

			</div>


			<div id="event-loader" class="loader loader-modal hidden">
				<div class="sk-spinner sk-spinner-three-bounce">
					<div class="sk-bounce1"></div>
					<div class="sk-bounce2"></div>
					<div class="sk-bounce3"></div>
				</div>
			</div>

		</div>


	</div>
</div>

<script type="text/javascript">
	$("#calendarentry-start_time").format({type: "daytime"});
	$("#calendarentry-end_time").format({type: "daytime"});


	// Shake modal after wrong validation
	<?php if ($card->hasErrors()) { ?>
	$('.modal-dialog').removeClass('fadeIn');
	$('.modal-dialog').addClass('shake');
	<?php } ?>

</script>


<?php CActiveForm::end(); ?>
