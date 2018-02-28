<?php

use yii\helpers\Html;

echo Html::a('<i class="fa fa-plus-circle"></i> ' . Yii::t("CardsModule.buttons", 'New Event'),
	$space->createUrl(
		'/cards/calendar/edit',
		array('card_id' => $card_id)),
    	array('class' => 'btn btn-primary', 'data-target' => '#globalModal')
	);
