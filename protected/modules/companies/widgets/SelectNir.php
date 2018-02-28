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
class SelectNir extends Widget
{
    public $contentContainer;
    public $show_go;
    public $space;
    public $card_id;

    public function run()
    {

        $space_company = [];

        $nir_relateds = NirRelated::findAll(array('id_space_pre_nir' => $this->contentContainer->id));


        foreach ($nir_relateds as $nir_related) {

            $companies = CompanySpace::findAll(array('space_id' => $nir_related->id_space_nir));
            $companies = ($companies) ? $companies : [];
            $space_company[] = (object) ['space' => $nir_related->getIdSpaceNir()->one(),
                'companies' => $companies];
        }


        return $this->render('selectNir', ['contentContainer' => $this->contentContainer,
            'nirs' => $space_company, 'show_go' => $this->show_go]);
    }

}

?>