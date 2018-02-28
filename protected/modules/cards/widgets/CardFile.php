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

use Yii;
use \yii\base\Widget;

/**
 * SpaceInviteButtonWidget
 *
 * @author Infoself
 * @package humhub.modules_core.space.widgets
 * @since 0.11
 */
class CardFile extends Widget
{

	public $space;
	public $card_id;

	public function run()
	{
		return $this->render('cardFile', array(
			'contentContainer'	=> $this->space,
			'card_id'			=> $this->card_id,

			'currentFolder' 	=> (object)array('id' => 0) //se lo añado para que no dé error
		));
	}

}