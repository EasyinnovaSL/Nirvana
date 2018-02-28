<?php

namespace humhub\modules\nda;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $sourcePath = '@humhub/modules/nda/assets';
    public $css = [
        'nda.css',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
