<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\nda\widgets;

use Yii;
use yii\web\HttpException;
use humhub\components\Widget;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\content\models\Content;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentActiveRecord;
use \humhub\modules\post\models\Post;
use humhub\modules\cards\models\Card;
use humhub\modules\cards\models\CardContent;
use humhub\modules\content\models\WallEntry;

/**
 * This widget is used include the comments functionality to a wall entry.
 *
 * Normally it shows a excerpt of all comments, but provides the functionality
 * to show all comments.
 *
 * @package humhub.modules_core.comment
 * @since 0.5
 */
class Form extends Widget
{

    /**
     * @inheritdoc
     */
	public $submitUrl = '/nda/nda-model/post';

    /**
     * @var string submit button text
     */
    public $submitButtonText;

    /**
     * @var ContentContainerActiveRecord this content will belong to
     */
    public $contentContainer;

    /**
     * @var string form implementation
     */
    protected $form = "";

	public $card_id;

	/*
    public function renderForm()
    {
	    $posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();



        return $this->render('form', array('card_id' => $this->card_id, 'posts' => $posts));
    }


    public function run()
    {
        if (!$this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost())) {
            return;
        }

        return parent::run();
    }*/

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->submitButtonText == "")
            $this->submitButtonText = Yii::t('ContentModule.widgets_ContentFormWidget', 'Submit');

        if ($this->contentContainer == null || !$this->contentContainer instanceof ContentContainerActiveRecord) {
            throw new HttpException(500, "No Content Container given!");
        }

        return parent::init();
    }

    /**
     * Returns the custom form implementation.
     *
     * @return string
     */
    public function renderForm()
    {
	    $posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();

        return $this->render('form', array('card_id' => $this->card_id, 'posts' => $posts));
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $defaultVisibility = Content::VISIBILITY_PUBLIC;
        if ($this->contentContainer instanceof Space) {
            $defaultVisibility = $this->contentContainer->getDefaultContentVisibility();
        }

        $canSwitchVisibility = false;
        if ($this->contentContainer->permissionManager->can(new \humhub\modules\content\permissions\CreatePublicContent())) {
            $canSwitchVisibility = true;
        } else {
            $defaultVisibility = Content::VISIBILITY_PRIVATE;
        }

				$wallEntry = CardContent::find()->where((array('card_id' => $this->card_id)))->all();


				$post = '';

				if(!empty($wallEntry)){
					//$posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();
					$posts = Post::find()->joinWith('content')->where(['content.id' => $wallEntry[0]->content_related_id])->all();
					$post = $posts[0];
				}


				$card 	= Card::findOne($this->card_id);

        return $this->render('@humhub/modules/nda/widgets/views/wallCreateContentForm', array(
                    'form' => $this->render('form', array('card_id' => $this->card_id, 'id' => $card->getUniqueId())),
                    'contentContainer' => $this->contentContainer,
                    'submitUrl' => $this->contentContainer->createUrl($this->submitUrl),
                    'submitButtonText' => $this->submitButtonText,
                    'defaultVisibility' => $defaultVisibility,
                    'canSwitchVisibility' => $canSwitchVisibility,
                    'wallEntry' => $wallEntry,
                    'id' => $card->getUniqueId(),
                    'card' => $card,
										'post' => $post
        ));
    }

    /**
     * Creates the given ContentActiveRecord based on given submitted form information.
     *
     * - Automatically assigns ContentContainer
     * - Access Check
     * - User Notification / File Uploads
     * - Reloads Wall after successfull creation or returns error json
     *
     * [See guide section](guide:dev-module-stream.md#CreateContentForm)
     *
     * @param ContentActiveRecord $record
     * @return string json
     */
    public static function create(ContentActiveRecord $record, ContentContainerActiveRecord $contentContainer = null)
    {
        Yii::$app->response->format = 'json';

        $visibility = Yii::$app->request->post('visibility');
        if ($visibility == Content::VISIBILITY_PUBLIC && !$contentContainer->permissionManager->can(new \humhub\modules\content\permissions\CreatePublicContent())) {
            $visibility = Content::VISIBILITY_PRIVATE;
        }
        $record->content->visibility = $visibility;

        $record->content->container = $contentContainer;

        // Handle Notify User Features of ContentFormWidget
        // ToDo: Check permissions of user guids
        $userGuids = Yii::$app->request->post('notifyUserInput');
        if ($userGuids != "") {
            foreach (explode(",", $userGuids) as $guid) {
                $user = User::findOne(['guid' => trim($guid)]);
                if ($user) {
                    $record->content->notifyUsersOfNewContent[] = $user;
                }
            }
        }

        // Store List of attached Files to add them after Save
        $record->content->attachFileGuidsAfterSave = Yii::$app->request->post('fileList');
        if ($record->validate() && $record->save()) {
            return array('wallEntryId' => $record->content->getFirstWallEntryId());
        }

        return array('errors' => $record->getErrors());
    }

}

?>
