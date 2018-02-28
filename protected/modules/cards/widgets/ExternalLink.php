<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 30/11/2016
 * Time: 13:34
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
class ExternalLink extends Widget
{
    public $space;
    public $card_id;
    public $url;
    public $user;       // Login username
    public $password;   // Login password

    public function run()
    {
        return $this->render('externalLink', array(
            'space' => $this->space,
            'card_id' => $this->card_id,
            'user' => $this->user,
            'password' => $this->password,
            'url' => $this->url
        ));
    }

}
