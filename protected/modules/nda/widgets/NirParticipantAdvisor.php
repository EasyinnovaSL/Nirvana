<?php

namespace humhub\modules\nda\widgets;

use humhub\components\Widget;


class NirParticipantAdvisor extends Widget
{
    public $space;
    public $card_id;

    /**
     * @inheritdoc
     */
    public function run()
    {

      return $this->render('nirParticipantAdvisor', array(
        'space'   => $this->space,
        'card_id' => $this->card_id
      ));
    }

}

?>
