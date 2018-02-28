<?php

/**
 * HumHub
 * Copyright © 2014 The HumHub Project
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 */

namespace humhub\modules\cards\widgets;

use humhub\modules\cards\behaviors\StepFlow;
use humhub\modules\user\models\Profile ;
use Yii;
use \yii\base\Widget;

/**
 * SpaceInviteButtonWidget
 *
 * @author Infoself
 * @package humhub.modules_core.space.widgets
 * @since 0.11
 */
class WelcomeScreen extends Widget
{
    public $space;

    public function run()
    {
        $workflow = StepFlow::currentWorkflow($this->space);

        $profile=Profile::find()
            ->join('LEFT OUTER JOIN', 'space_membership', 'space_membership.user_id = profile.user_id')
            ->join('LEFT OUTER JOIN','space_user_role', 'space_user_role.user_id = space_membership.user_id')
            ->where(['space_membership.space_id' => $this->space->id, 'space_user_role.user_role_id' => 1])->one();
        return $this->render('welcomeScreen', array('space' => $this->space, 'workflow_id' => $workflow->workflow_id, 'profile' => $profile));
    }

}
