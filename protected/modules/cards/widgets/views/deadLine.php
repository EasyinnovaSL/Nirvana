<?php
use yii\helpers\Html;
?>

<span class="label label-card-end-date pull-right">
	<?php
	$date = new DateTime($card->card_end_date);
	echo Html::a(
		$date->format('d M'),
		$contentContainer->createUrl('/cards/card/deadline', array('card_id' => $card->id)),
		array('class' => 'btn btn-primary', 'data-target' => '#globalModal')
	);
	?>
</span>