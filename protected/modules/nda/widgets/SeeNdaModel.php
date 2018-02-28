<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaModel;
use humhub\modules\nda\models\NdaAgreement;
use humhub\modules\nda\models\NdaModelChoose;


class SeeNdaModel extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {

      $nda_models = [];
      foreach (NdaModel::find()->All() as $nda) $nda_models[$nda->id] = $nda->name;


      return $this->render('seeNdaModel', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'nda_models' => $nda_models
      ));
    }

}

?>
