<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\controllers
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\controllers;

use lispa\amos\dashboard\controllers\base\DashboardController;
use yii\helpers\Url;

/**
 * Class DefaultController
 * @package lispa\amos\partnershipprofiles\controllers
 */
class DefaultController extends DashboardController
{
    /**
     * @var string $layout Layout for internal dashboard.
     */
    public $layout = 'dashboard_interna';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->setUpLayout();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex($oldDashboard = null)
    {
        if (is_null($oldDashboard)) {
            return $this->redirect(['/partnershipprofiles/partnership-profiles/own-interest']);
        }
        Url::remember();
        $params = ['currentDashboard' => $this->getCurrentDashboard()];
        return $this->render('index', $params);
    }
}
