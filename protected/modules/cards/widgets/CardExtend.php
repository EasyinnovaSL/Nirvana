<?php

namespace humhub\modules\cards\widgets;
use humhub\widgets\BaseStack;

/**
 * WallEntryLinksWidget is an instance of StackWidget.
 *
 * Display some links below a wall entry. Allows modules to add own links to
 * the wall entry.
 *
 * @package humhub.modules_core.wall.widgets
 * @since 0.5
 */
class CardExtend extends BaseStack
{

    /**
     * Object derived from HActiveRecordContent
     *
     * @var type
     */
    public $object = null;

}

?>