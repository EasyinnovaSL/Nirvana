<?php

namespace humhub\modules\companies\widgets;

use humhub\components\Widget;
use humhub\modules\companies\models\CompanySpace;
use humhub\modules\companies\models\NirRelated;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Infoself
 */
class TypeAdvisor extends Widget
{
    public $contentContainer;
    public $is_innovator;
    public $card_id;

    public function run()
    {
        return $this->render('typeAdvisor', ['contentContainer' => $this->contentContainer,
            'is_innovator' => $this->is_innovator, 'card_id' => $this->card_id]);
    }

}

?>