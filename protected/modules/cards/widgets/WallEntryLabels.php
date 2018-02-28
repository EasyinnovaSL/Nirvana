<?php

namespace humhub\modules\cards\widgets;

use humhub\modules\content\widgets;
use \yii\base\Widget;

class Labels extends Widget
{

    /**
     * Content Object with SIContentBehaviour
     * @var type
     */
    public $object;

    /**
     * Executes the widget.
     */
    public function run()
    {
        return $this->render('labels', array(
            'object' => $this->object,
        ));
    }

}

?>
