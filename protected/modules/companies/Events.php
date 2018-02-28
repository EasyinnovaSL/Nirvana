<?php

namespace humhub\modules\companies;

use Yii;
use humhub\modules\cards\widgets\CardExtend;
use yii\base\Event;
use humhub\modules\companies\widgets\SwitchCards;
use humhub\components\Widget;
use humhub\modules\space\models\Space;

/**
 * Companies Events
 *
 * @author infoself
 */

class Events extends \yii\base\Object
{

	public static function manageEvents($event)
	{

		Event::on(CardExtend::className(), CardExtend::EVENT_INIT,
			array(Events::className(), 'onCardExtend'));

		Event::on('humhub\modules\space\widgets\Chooser', Widget::EVENT_CREATE,
			array(Events::className(), 'onSpaceProjectCreate'));

		Event::on('humhub\modules\space\models\Space', Space::EVENT_BEFORE_INSERT,
			array(Events::className(), 'onSpaceBeforeInsert'));

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

	/**
	 * Gets space_type_id and adds var to model
	 *
	 * @param type $event
	 */

	public static function onSpaceBeforeInsert($event)
	{
		$space = $event->sender;
		if(!empty(Yii::$app->request->post('Space')['space_type_id'])){
			$space->space_type_id = Yii::$app->request->post('Space')['space_type_id'];
		}
	}


}