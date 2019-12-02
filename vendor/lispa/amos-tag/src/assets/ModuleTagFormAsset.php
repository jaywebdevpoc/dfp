<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\tag
 * @category   CategoryName
 */

namespace lispa\amos\tag\assets;

use lispa\amos\core\widget\WidgetAbstract;
use yii\web\AssetBundle;

class ModuleTagFormAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-tag/src/assets/web';

    public $css = [
        'less/tag.less' 
    ];
    public $js = [
        'js/tag-form.js',
    ];
    public $depends = [
    ];

    /*
    //force reset cache asset (devel ONLY)
    public $publishOptions = [
        'forceCopy'=>true,
    ];
    */

    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');

        if(!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS){
            $this->css = ['less/tag_fullsize.less'];
        }

        if(!empty($moduleL))
        { $this->depends [] = 'lispa\amos\layout\assets\BaseAsset'; }
        else
        { $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset'; }
        parent::init();
    }
}
