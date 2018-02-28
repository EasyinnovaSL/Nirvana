<?php

namespace humhub\modules\cards\widgets;

use humhub\components\Widget;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Infoself
 */
class DismissButton extends Widget
{
    public $contentContainer;
    public $card;
    public $styleClass;

    public function run() {
        return $this->render('dismissButton', [
            'contentContainer' => $this->contentContainer,
            'card' => $this->card,
            'styleClass' => $this->styleClass,
            'mandatory' => $this->card->getCard()->one()->card_mandatory
        ]);
    }


}

?>