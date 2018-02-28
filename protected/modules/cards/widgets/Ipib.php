<?php
/**
 * Created by IntelliJ IDEA.
 * User: Victor Muñoz
 * Date: 24/01/2017
 * Time: 12:33
 */

namespace humhub\modules\cards\widgets;

use humhub\modules\linklist\models\Link;
use Yii;
use \yii\base\Widget;

class Ipib extends Widget
{
    public $space;
    public $card_id;
    public $contentContainer;

    public function run()
    {
        return $this->render('ipib', array(
            'space' => $this->space,
            'contentContainer' => $this->contentContainer,
            'card_id' => $this->card_id
        ));
    }
}