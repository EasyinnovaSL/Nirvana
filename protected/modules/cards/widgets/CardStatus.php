<?php

namespace humhub\modules\cards\widgets;

use humhub\components\Widget;
use humhub\modules\cards\models\UserCard;
use Yii;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Infoself
 */
class CardStatus extends Widget
{
    public $contentContainer;
    public $card;

    public function run()
    {
        $status = \humhub\modules\cards\models\UserCard::findOne(array('card_id' => $this->card->id,
            'user_id' => Yii::$app->user->getId()));

        $class_status = ($status["card_status"] == UserCard::STATUS_COMPLETED) ? 'success' :
            ($status["card_status"] == UserCard::STATUS_DISMISSED) ? 'danger' :
            'info';

        return $this->render('cardStatus', ['contentContainer' => $this->contentContainer,
            'class_status' => $class_status, 'card_status' => $status["card_status"]]);
    }


}

?>