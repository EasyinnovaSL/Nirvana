<?php

namespace humhub\modules\cards;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $sourcePath = '@humhub/modules/cards/assets';
    public $css = [
        'custom.css' ,'nirvana.css', 'autocomplete.css' //'bootstrap-material-design.min.css', 'ripples.min.css'
    ];
    public $js = [
        'nirvana.js', //'material.min.js','ripples.min.js'
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}