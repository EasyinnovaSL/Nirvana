<?php

namespace humhub\modules\cards\widgets;

use Yii;
use humhub\modules\content\components\ContentActiveRecord;

/**
 * This widget is used include the files functionality to a wall entry.
 *
 * @package humhub.modules_core.file
 * @since 0.5
 */
class ShowCardFiles extends \yii\base\Widget
{

	/**
	 * Object to show files from
	 */
	public $object = null;

	/**
	 * Executes the widget.
	 */
	public function run()
	{
		$blacklisted_objects = explode(',', Yii::$app->getModule('file')->settings->get('showFilesWidgetBlacklist'));
		if (!in_array(get_class($this->object), $blacklisted_objects)) {
			$files = \humhub\modules\file\models\File::getFilesOfObject($this->object);
			return $this->render('showFiles', array('files' => $files,
				'maxPreviewImageWidth' => Yii::$app->getModule('file')->settings->get('maxPreviewImageWidth'),
				'maxPreviewImageHeight' => Yii::$app->getModule('file')->settings->get('maxPreviewImageHeight'),
				'hideImageFileInfo' => Yii::$app->getModule('file')->settings->get('hideImageFileInfo')
			));
		}
	}

}

?>