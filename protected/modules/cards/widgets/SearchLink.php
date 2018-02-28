<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 30/11/2016
 * Time: 11:30
 */

namespace humhub\modules\cards\widgets;

use Yii;
use \yii\base\Widget;

/**
 * SpaceInviteButtonWidget
 *
 * @author Victor Muñoz
 * @package humhub.modules_core.space.widgets
 * @since 0.11
 */
class SearchLink extends Widget
{
    public $space;
    public $card_id;
    public $url;

    public function run()
    {
        return $this->render('searchLink', array(
            'space' => $this->space,
            'card_id' => $this->card_id,
            'url' => $this->url
        ));
    }

}
