<?php

namespace humhub\modules\nda;

use Yii;
use humhub\modules\cards\widgets\CardExtend;
use yii\base\Event;
use humhub\modules\nda\widgets\SwitchCards;
use humhub\components\Widget;
use humhub\modules\nda\Events;

/**
 * Companies Events
 *
 * @author infoself
 */

class Events extends \yii\base\Object
{

	public static function manageEvents($event)
	{

	    Event::on(CardExtend::className(), CardExtend::EVENT_INIT, array(Events::className(), 'onCardExtend'));

	    /*Event::on('humhub\modules\space\widgets\Chooser', Widget::EVENT_CREATE,
	        array(Events::className(), 'onSpaceProjectCreate'));*/

	}


	public static function onCardExtend($event)
	{
	    $event->sender->addWidget(SwitchCards::className(), array('contentContainer' => $event->sender->object->content->getSpace(), 'card' => $event->sender->object));
	}

	/**
	 * Adds Create Project button to sidebar
	 *
	 * @param type $event
	 */

	public static function onSpaceProjectCreate($event)
	{
	 	$event->config['class'] = widgets\Chooser::className();
	}

}
