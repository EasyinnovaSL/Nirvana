<?php

namespace humhub\modules\loginUsers;

use Yii;
use humhub\modules\cards\widgets\CardExtend;
use yii\base\Event;
use humhub\modules\companies\widgets\SwitchCards;
use humhub\components\Widget;

/**
 * loginUsers Events
 *
 * @author easyinnova
 */

class Events extends \yii\base\Object
{

	public static function onAccountTopMenuRun($event){
		//$event->sender->template =  "@humhub/modules/loginUsers/widgets/views/accountTopMenu";
	}

}
