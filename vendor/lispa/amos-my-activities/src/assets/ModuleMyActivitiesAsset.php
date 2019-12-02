<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\myactivities\assets
 * @category   CategoryName
 */

namespace lispa\amos\myactivities\assets;

use lispa\amos\core\widget\WidgetAbstract;
use yii\web\AssetBundle;

/**
 * Class ModuleMyActivitiesAsset
 * @package lispa\amos\myactivities\assets
 */
class ModuleMyActivitiesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/lispa/amos-my-activities/src/assets/web';

    /**
     * @inheritdoc
     */
    public $css = [
        'less/my-activities.less'

    ];

    /**
     * @inheritdoc
     */
    public $js = [
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $moduleL = \Yii::$app->getModule('layout');

        if(!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS){
            $this->css = ['less/my-activities_fullsize.less'];
        }


        if (!empty($moduleL)) {
            $this->depends [] = 'lispa\amos\layout\assets\BaseAsset';
        } else {
            $this->depends [] = 'lispa\amos\core\views\assets\AmosCoreAsset';
        }
        parent::init();
    }
}
