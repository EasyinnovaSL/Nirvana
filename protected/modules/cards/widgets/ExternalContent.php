<?php
/**
 * Created by Victor Muñoz.
 * User: easy
 * Date: 28/11/2016
 * Time: 13:08
 */

namespace humhub\modules\cards\widgets;

use Yii;
use \yii\base\Widget;

/**
 * ExternalContentWidget
 *
 * @author Victor Muñoz
 * @package humhub.modules_core.space.widgets
 * @since 0.11
 */
class ExternalContent extends Widget
{
    public $space;
    public $card_id;
    public $card;
    public $contentContainer;

    public $login_url;  // Login page
    public $user;       // Login username
    public $password;   // Login password
    public $destination_url;    // Page to go after login
    public $destination_url2;   // Page to go after destination url is loaded
    public $frame_id;   // Unique id of the iframe

    public function run()
    {
        return $this->render('externalContent', array(
            'space' => $this->space,
            'contentContainer' => $this->contentContainer,
            'card' => $this->card,
            'card_id' => $this->card_id,
            'login_url' => $this->login_url,
            'user' => $this->user,
            'password' => $this->password,
            'destination_url' => $this->destination_url,
            'destination_url2' => $this->destination_url2,
            'frame_id' => $this->frame_id
        ));
    }

}
