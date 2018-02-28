<?php

namespace humhub\modules\nda\widgets;

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
class SwitchCards extends Widget
{
    public $contentContainer;
    public $card;

    public function run()
    {
        return $this->render('switchCard', ['contentContainer' => $this->contentContainer,
            'card' => $this->card, 'option' => $this->card->getCard()->one()->card_type_id]);
    }

}

?>
