<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;


class NdaModelDiscusion extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {

      return $this->render('ndaModelDiscusion', array(
        'space'   => $this->space,
        'card_id' => $this->card_id
      ));
    }

}

?>
