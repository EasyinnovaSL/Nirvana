<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaAgreement;


class SignNdaModel extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {

      $modelIsSigned = NdaAgreement::findOne(['space_id' => $this->space->id, 'user_id' => \Yii::$app->user->id, 'status' => 'signed']);



      return $this->render('signNdaModel', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'modelIsSigned' => $modelIsSigned
      ));
    }

}

?>
