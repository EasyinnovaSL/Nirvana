<?php

namespace humhub\modules\companies\widgets;

use humhub\components\Widget;


class CreateFormCompany extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */

    public function run()
    {
      $model = new \humhub\modules\companies\models\Company();

      return $this->render('form', array(
        'model'   => $model,
        'space'   => $this->space,
        'card_id' => $this->card_id
      ));
    }

}

?>
