<?php

namespace humhub\modules\loginUsers;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $sourcePath = '@humhub/modules/loginUsers/assets';

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
