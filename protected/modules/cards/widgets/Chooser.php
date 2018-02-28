<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cards\widgets;

use Yii;

/**
 * Description of Chooser
 *
 * @author infoself
 */
class Chooser extends \humhub\modules\space\widgets\Chooser
{

    public $spaceTypes = null;

    public function init()
    {
        parent::init();
        $this->spaceTypes = \humhub\modules\enterprise\modules\spacetype\models\Type::find()->orderBy(['sort_key' => SORT_ASC])->all();
    }

    /**
     * Displays / Run the Widgets
     */
    public function run()
    {
        if (Yii::$app->user->isGuest)
            return;

        $memberships = $this->getMembershipQuery()->all();

        $typeMembershipMap = [];

        foreach ($this->spaceTypes as $spaceType) {

            $typeMembershipMap[$spaceType->id] = [
                'spaceType' => $spaceType,
                'memberships' => [],
            ];

            foreach ($memberships as $membership) {

                if ($membership->space->space_type_id == $spaceType->id) {
                    $typeMembershipMap[$spaceType->id]['memberships'][] = $membership;
                }
            }
        }


        return $this->render('spaceChooser', [
            'currentSpace' => $this->getCurrentSpace(),
            'canCreateSpace' => $this->canCreateSpace(),
            'spaceTypes' => $this->spaceTypes,
            'memberships' => $memberships,
            'createSpaceTypes' => $this->getCreateSpaceTypes(),
            'typeMembershipMap' => $typeMembershipMap,
        ]);
    }

    public function getTypeTitle($space)
    {
        if (count($this->spaceTypes) < 2) {
            return "";
        }

        foreach ($this->spaceTypes as $type) {
            if ($type->id == $space->space_type_id) {
                return $type->item_title;
            }
        }

        return "";
    }

    public function getCreateSpaceTypes()
    {
        $types = [];

        if (!$this->canCreateSpace()) {
            return [];
        }

        foreach ($this->spaceTypes as $type) {
            if ($type->canCreateSpace()) {
                $types[] = $type;
            }
        }

        return $types;
    }

}
