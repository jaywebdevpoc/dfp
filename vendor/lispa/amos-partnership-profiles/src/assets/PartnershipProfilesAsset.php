<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\assets
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\assets;

use yii\web\AssetBundle;
use lispa\amos\core\widget\WidgetAbstract;

/**
 * Class PartnershipProfilesAsset
 * @package lispa\amos\partnershipprofiles\assets
 */
class PartnershipProfilesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/lispa/amos-partnership-profiles/src/assets/web';
    
    /**
     * @inheritdoc
     */
    public $js = [
    ];
    
    /**
     * @inheritdoc
     */
    public $css = [
        'less/partnership-profiles.less',
    ];
    
    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset'
    ];

    public function init()
    {
        if(!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS){
            $this->css = ['less/partnership-profiles_fullsize.less'];
        }

        parent::init();
    }
}