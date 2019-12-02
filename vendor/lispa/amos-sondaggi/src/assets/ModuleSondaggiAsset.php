<?php

namespace lispa\amos\sondaggi\assets;

use yii\web\AssetBundle;
use lispa\amos\core\widget\WidgetAbstract;

class ModuleSondaggiAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-sondaggi/src/assets/web';

    public $css = [
        'css/stile.css'
    ];
    public $js = [
        'js/condizioneSondaggio.js'
    ];
    public $depends = [        
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'kartik\depdrop\DepDropExtAsset'
    ];

    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');
        if(!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS){
            $this->css = ['less/sondaggi-fullsize.less'];
        }
        if(!empty($moduleL))
        { $this->depends [] = 'lispa\amos\layout\assets\BaseAsset'; }
        else
        { $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset'; }
        parent::init();
    }
}
