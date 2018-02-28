<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaModel;
use humhub\modules\nda\models\NdaAgreement;
use humhub\modules\nda\models\NdaModelChoose;


class ChooseNdaModel extends Widget
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

      $query = NdaModelChoose::find();
      $query->joinWith('nda_model', true, 'INNER JOIN');
      $query->where(['nda_model_chose.space_id' => $this->space->id]);
      $nda_model_chose = $query->all();

      return $this->render('chooseNdaModel', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'nda_models' => $nda_models,
        'ndaModelConfirmExist' => $ndaModelConfirmExist,
        'nda_model_chose' => $nda_model_chose
      ));
    }

}

?>
