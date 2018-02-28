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
class StatusLabel extends Widget
{
    public $poll;

    public function run()
    {
        return $this->render('closeButton', ['poll' => $this->poll]);
    }

}

?>