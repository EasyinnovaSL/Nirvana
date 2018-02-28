<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 24/01/2017
 * Time: 12:33
 */

namespace humhub\modules\cards\widgets;

use humhub\modules\cards\models\EasyppProfile;
use Yii;
use \yii\base\Widget;

class ProfileStatus extends Widget
{
    public $space;
    public $card_id;
    public $submitted;
    public $online;

    public function run()
    {
        $profile = EasyppProfile::findOne(['space_id' => $this->space->id]);
        if ($profile != null) {
            $this->submitted = true;
            $this->online = $profile->online;
        }

        return $this->render('profileStatus', array(
            'space' => $this->space,
            'card_id' => $this->card_id,
            'submitted' => $this->submitted,
            'online' => $this->online
        ));
    }
}