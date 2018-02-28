<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;
use humhub\modules\nda\models\NdaAgreement;
use yii\db\Query;

class NdaAgreementModel extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {

	  /*$query = NdaAgreement::find();
      $query->joinWith('user', true, 'INNER JOIN');
      $query->innerJoin('profile', 'user.id = profile.user_id');
      $query->where(['nda_agreement.space_id' => $this->space->id]);
      $users = $query->all();*/

      $users = (new \yii\db\Query())
  	  ->select('nda_agreement.status, profile.firstname, profile.lastname, space_user_role.user_role_id')
  	  ->from('nda_agreement')
  	  ->innerJoin('user', 'nda_agreement.user_id = user.id')
  	  ->innerJoin('profile', 'profile.user_id = user.id')
          ->innerJoin('space_user_role', 'user.id = space_user_role.user_id')
  	  ->where(['nda_agreement.space_id' => $this->space->id, 'space_user_role.space_id' => $this->space->id])
  	  ->all();


      return $this->render('ndaAgreement', array(
        'space'   => $this->space,
        'card_id' => $this->card_id,
        'users'	  => $users
      ));
    }

}

?>
