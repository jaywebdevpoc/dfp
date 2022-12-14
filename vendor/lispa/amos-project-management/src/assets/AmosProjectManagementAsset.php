<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\assets;

use yii\web\AssetBundle;

/**
 * Class AmosProjectManagementAsset
 * @package lispa\amos\projectmanagement\assets
 */
class AmosProjectManagementAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-project-management/src/assets/web';

    public $css = [
        'less/project-management.less',
    ];

    public $depends = [
    ];

    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');
        if (!empty($moduleL)) {
            $this->depends [] = 'lispa\amos\layout\assets\BaseAsset';
        } else {
            $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset';
        }
        parent::init();
    }

}