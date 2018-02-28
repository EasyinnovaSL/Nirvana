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
use humhub\modules\cards\models\CardContent;
use humhub\modules\cards\models\Card;

/**
 * This widget is used include the post form.
 * It normally should be placed above a steam.
 *
 * @since 0.5
 */
class FormDiscusion extends \humhub\modules\nda\widgets\Form
{

    /**
     * @inheritdoc
     */
    public function renderForm()
    {
        $query = NdaModelChoose::find();
        $query->joinWith('nda_model', true, 'INNER JOIN');
        $query->where(['nda_model_chose.space_id' => $this->contentContainer->id]);
        $nda_model_chose = $query->all();

        $wallEntry = CardContent::find()->where((array('card_id' => $this->card_id)))->all();

				$card 	= Card::findOne($this->card_id);

        return $this->render('form', [
          'nda_model_chose' => $nda_model_chose,
          'wallEntry' => $wallEntry,
          'id' => $card->getUniqueId(),
          'card' => $card
        ]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
      if (!$this->contentContainer->permissionManager->can(new \humhub\modules\post\permissions\CreatePost())) {
          return;
      }

      return parent::run();
    }

}

?>
