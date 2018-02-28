<?php

use yii\helpers\Html;

//'/example/poll/show
echo Html::a('<i class="fa fa-plus-circle"></i> ' . Yii::t("CardsModule.buttons", 'Nueva Encuesta'), $space->createUrl('/example/poll/show', array('card_id' => $card_id)),
    array('class' => 'btn btn-primary', 'data-target' => '#globalModal'));
