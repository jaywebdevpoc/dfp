<?php

namespace lispa\amos\sondaggi\assets;

use yii\web\AssetBundle;

class ModuleRisultatiFrontendAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-sondaggi/src/assets/web';

    public $css = [
        'less/sondaggi-frontend.less'
    ];
    public $js = [
        'js/sondaggi-frontend.js'        
    ];
    public $depends = [        
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'kartik\depdrop\DepDropExtAsset'
    ];

}
