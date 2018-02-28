<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaModel;
use humhub\modules\nda\models\NdaAgreement;
use humhub\modules\nda\models\NdaModelChoose;


class ConfirmNdaModel extends Widget
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

      $ndaModelConfirmExist = NdaAgreement::findOne(['space_id' => $this->space->id]);
      $ndaModelChoose       = NdaModelChoose::findOne(['space_id' => $this->space->id]);

      return $this->render('confirmNdaModel', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'nda_models' => $nda_models,
        'ndaModelConfirmExist' => $ndaModelConfirmExist,
        'ndaModelChoose' => $ndaModelChoose
      ));
    }

}

?>
