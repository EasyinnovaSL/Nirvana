<?php

namespace humhub\modules\help;

use humhub\modules\companies\controllers\cardsStepsController;
use Yii;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerModule;

class Module extends ContentContainerModule
{
    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            Space::className(),
        ];
    }

  // Is called when the whole module is disabled
  public function disable()
  {
      // Clear all Module data and call parent disable
      parent::disable();
  }


  public function init(){
    parent::init();

  }

}
