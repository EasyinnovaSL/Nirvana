<?php

namespace humhub\modules\companies;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $sourcePath = '@humhub/modules/companies/assets';
    public $css = [
        'companies.css',
    ];
    public $js = [
        'typeahead.js'
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
