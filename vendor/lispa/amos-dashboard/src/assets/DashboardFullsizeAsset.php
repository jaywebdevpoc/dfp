<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\dashboard
 * @category   CategoryName
 */

namespace lispa\amos\dashboard\assets;

use yii\web\AssetBundle;

class DashboardFullsizeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/lispa/amos-dashboard/src/assets/web';
    public $css        = [
        'less/dashboardFullsize.less'
    ];
    public $js         = [
        'js/dashboard_fullsize.js',
        'js/modal-dashboard.js'
    ];
    public $depends = [
    ];
}