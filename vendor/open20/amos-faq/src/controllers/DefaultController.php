<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq\controllers
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace open20\amos\faq\controllers;

use open20\amos\dashboard\controllers\base\DashboardController;
use yii\helpers\Url;

/**
 * Class DefaultController
 * @package open20\amos\faq\controllers
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
    public function init() {

        parent::init();
        $this->setUpLayout();
        // custom initialization code goes here
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex($oldDashboard = null)
    {
        if (is_null($oldDashboard)) {
            return $this->redirect(['/faq/faq/index']);
        }
        Url::remember();
        $params = ['currentDashboard' => $this->getCurrentDashboard()];
        return $this->render('index', $params);
    }

    /**
     * @param null $layout
     * @return bool
     */
    public function setUpLayout($layout = null){
        if ($layout === false){
            $this->layout = false;
            return true;
        }
        $module = \Yii::$app->getModule('layout');
        if(empty($module)){
            $this->layout =  '@vendor/open20/amos-core/views/layouts/' . (!empty($layout) ? $layout : $this->layout);
            return true;
        }
        $this->layout = (!empty($layout)) ? $layout : $this->layout;
        return true;
    }
}
