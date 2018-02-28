<?php

namespace humhub\modules\companies\widgets;

use humhub\components\Widget;
use humhub\modules\cards\models\SpaceUserRole;
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
class ChooseTypeAdvisor extends Widget
{
    public $contentContainer;
    public $card_id;
    public $canChange;

    public function run()
    {
        $advisor_role = SpaceUserRole::findOne(array('space_id' => $this->contentContainer->id,
            'user_role_id' => array(3, 4)));

        return $this->render('chooseTypeAdvisor', ['contentContainer' => $this->contentContainer,
            'card_id' => $this->card_id, 'advisor_role' => $advisor_role,
        'canChange' => $this->canChange]);
    }

}

?>