<?php

namespace humhub\modules\cards\widgets;

use humhub\modules\content\widgets\WallEntry;
use \humhub\modules\space\widgets\InviteButton;
use \humhub\modules\file\widgets\FileUploadButton;

/**
 * Cards Simple ( Type 1 )
 *
 * @package humhub.modules_core.example.widgets
 * @since 0.11
 * @author Infoself
 */
class CardSimple extends WallEntry
{

    public $showMoreButton = false;
    public $space;
    public $contentContainer;

    public $icon;
    public $title;
    public $description;
    public $content;
    public $p_button;
    public $t_button;
    public $is_mandatory = 1;

    /**
     * Executes the widgets
     */
    public function run()
    {



        return $this->render('entry', array('card' => $this->contentObject,
            'user' => $this->contentObject->content->user,
            'contentContainer' => $this->contentObject->content->container));
    }



}

?>
