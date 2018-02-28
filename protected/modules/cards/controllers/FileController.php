<?php

namespace humhub\modules\cards\controllers;

use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\StepUserSpace;
use humhub\modules\cfiles\models\File;
use humhub\modules\cards\behaviors\StepFlow;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;
use yii\helpers\Html;
use humhub\modules\content\components\ContentContainerController;
use yii\web\UploadedFile;

/**
 * Default controller for the `example` module
 */
class FileController extends ContentContainerController {

	public function behaviors()
	{
		return array(
			StepFlow::className()
		);
	}


    public static function onFileUploaded($event) {
		$file = $event->sender;
	}

	public $files = array();
	/**
	 * Action to upload multiple files.
	 * @return multitype:boolean multitype:
	 */
	public function actionIndex() {
		Yii::$app->response->format = 'json';

		$response = [];

		foreach (UploadedFile::getInstancesByName('files') as $cFile) {
			$currentFolderId = 0;

			// check if the file already exists in this dir
			$filesQuery = File::find()->contentContainer($this->contentContainer)->joinWith('baseFile')
				->readable()
				->andWhere([
					'title' => File::sanitizeFilename($cFile->name),
					'parent_folder_id' => $currentFolderId
				]);
			$file = $filesQuery->one();

			// if not, initialize new File
			if (empty($file)) {
				$file = new File();
				$humhubFile = new \humhub\modules\file\models\File();
			}             // else replace the existing file
			else {
				$humhubFile = $file->baseFile;
				// logging file replacement
				$response['infomessages'][] = Yii::t('CfilesModule.base', '%title% was replaced by a newer version.', [
					'%title%' => $file->title
				]);
				$response['log'] = true;
			}

			$humhubFile->setUploadedFile($cFile);
			if ($humhubFile->save()) {

				$file->content->container = $this->contentContainer;
				$file->parent_folder_id = 0;


				if ($file->save()) {
					$card_id = Yii::$app->request->get('card_id');
					StepFlow::CardContentRelated($card_id, $file->getContent()->one()->id, File::className(), 2);
					StepFlow::updateFlowStatus($card_id, StepUserSpace::STATUS_COMPLETED);

					$humhubFile->object_model = $file->className();
					$humhubFile->object_id = $file->id;
					$humhubFile->save();
					$this->files[] = array_merge($humhubFile->getInfoArray(), ['fileList' => []	]);
				} else {
					$count = 0;
					$messages = "";
					// show multiple occurred errors
					foreach ($file->errors as $key => $message) {
						$messages .= ($count ++ ? ' | ' : '') . $message[0];
					}
					$response['errormessages'][] = Yii::t('CfilesModule.base', 'Could not save file %title%. ', [
							'%title%' => $file->title
						]) . $messages;
					$response['log'] = true;
				}
			} else {
				$count = 0;
				$messages = "";
				// show multiple occurred errors
				foreach ($humhubFile->errors as $key => $message) {
					$messages .= ($count ++ ? ' | ' : '') . $message[0];
				}
				$response['errormessages'][] = Yii::t('CfilesModule.base', 'Could not save file %title%. ', [
						'%title%' => $humhubFile->filename
					]) . $messages;
				$response['log'] = true;
			}
		}

		$response['files'] = $this->files;
		return $response;
	}


}
