<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\nda\widgets;

use \humhub\modules\post\models\Post;
use humhub\modules\content\models\Content;
use humhub\modules\nda\models\NdaModelChoose;

/**
 * This widget is used include the post form.
 * It normally should be placed above a steam.
 *
 * @since 0.5
 */
class FormTask extends \yii\base\Widget
//class Form extends \humhub\modules\content\widgets\WallCreateContentForm
//class Form extends \humhub\modules\comment\widgets\Comments
{

    public $contentContainer;
    public $card_id;
    public $card;
    /**
     * @inheritdoc
     */
    public $submitUrl = '/nda/post-task/post';

    /**
     * @inheritdoc
     */
    public function renderForm()
    {
        //return $this->render('form', array('contentContainer' => $this->contentContainer, 'card_id' => $this->card_id, 'card' => $this->card));
        /*$canCreatePosts = $this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost());

        $posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();

        return $this->render('form_bueno', array(
          'canCreatePosts' => $canCreatePosts,
          'contentContainer' => $this->contentContainer,
          'card_id' => $this->card_id,
          'posts' => $posts,
          'card' => $this->card,
          'submitUrl' => $this->submitUrl
        ));*/

        //$posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();

        //return $this->render('form', array());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /*if (!$this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost())) {
            return;
        }*/


        $canCreatePosts = $this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost());

        $posts = Post::find()->contentContainer($this->contentContainer)->readable()->all();

        /*echo "<pre>";
        echo var_dump($posts);
        echo "</pre>";*/

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

        $query = NdaModelChoose::find();
        $query->joinWith('nda_model', true, 'INNER JOIN');
        $query->where(['nda_model_chose.space_id' => $this->contentContainer->id]);
        $nda_model_chose = $query->all();

        return $this->render('form_task', array(
          'canCreatePosts' => $canCreatePosts,
          'contentContainer' => $this->contentContainer,
          'card_id' => $this->card_id,
          'posts' => $posts,
          'card' => $this->card,
          'submitUrl' => $this->submitUrl,
          'defaultVisibility' => $defaultVisibility,
          'nda_model_chose' => $nda_model_chose
        ));
        //return parent::run();
    }

}

?>
