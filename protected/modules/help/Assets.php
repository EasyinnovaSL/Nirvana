<?php

namespace humhub\modules\help;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $sourcePath = '@humhub/modules/help/assets';


    public $css = [
        'css/enjoyhint.css',
    ];

    public $js = [
        'js/enjoyhint.min.js',
    ];


    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
