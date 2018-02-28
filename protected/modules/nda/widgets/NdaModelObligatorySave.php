<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaModelObligatory;

class NdaModelObligatorySave extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {
      $ndaModelObligatory = NdaModelObligatory::findOne(['space_id' => $this->space->id]);

      return $this->render('ndaModelObligatory', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'ndaModelObligatory' => ($ndaModelObligatory) ? 1 : 0
      ));
    }


}

?>
