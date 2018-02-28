<?php

namespace humhub\modules\companies\widgets;

use humhub\components\Widget;
use humhub\modules\companies\models\CompanySpace;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Infoself
 */
class SelectCompanies extends Widget
{
    public $contentContainer;
    public $show_go;

    public function run()
    {



        $companies = CompanySpace::findAll(array('space_id' => $this->contentContainer->id));

        return $this->render('selectCompanies', ['contentContainer' => $this->contentContainer,
            'companies' => $companies]);
    }

}

?>