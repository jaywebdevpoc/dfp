<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\news
 * @category   CategoryName
 */

namespace lispa\amos\attachments\assets;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower-asset/jquery-cropper/dist';

    public $css = [
       // 'less/attachments.less',
    ];
    public $js = [
        'jquery-cropper.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');

        if(!empty($moduleL)){
            $this->depends [] = 'lispa\amos\layout\assets\BaseAsset';
        }else{
            $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset';
        }

        parent::init();
    }
}