<?php

namespace humhub\modules\cards\widgets;

use humhub\components\Widget;
use humhub\modules\cards\models\UserCard;
use humhub\modules\cards\models\Card;
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
class CompletedButton extends Widget
{
    public $contentContainer;
    public $card;

    public function run() {
        $status=$this->card->getStatus()->card_status;

        if($status == UserCard::STATUS_ONGOING) {

            if ($this->card->getChilds() == null) {
                return $this->render('completedButton', [
                    'contentContainer' => $this->contentContainer,
                    'card' => $this->card,
                    'status' => $status
                ]);
            }

        }
    }


}

?>