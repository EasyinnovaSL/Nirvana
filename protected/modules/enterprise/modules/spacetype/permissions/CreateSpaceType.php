<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype\permissions;

class CreateSpaceType extends \humhub\libs\BasePermission
{

    /**
     * @var \humhub\modules\space\models\Type
     */
    public $spaceType;

    /**
     * @inheritdoc
     */
    protected $title = "Create space type";

    /**
     * @inheritdoc
     */
    protected $description = "Can create space type";

    /**
     * @inheritdoc
     */
    protected $moduleId = 'enterprise';

    /**
     * @inheritdoc
     */
    protected $defaultState = self::STATE_ALLOW;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return 'create_space_type_' . $this->spaceType->id;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->title . ": " . $this->spaceType->item_title;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description . ": " . $this->spaceType->item_title;
    }

}
