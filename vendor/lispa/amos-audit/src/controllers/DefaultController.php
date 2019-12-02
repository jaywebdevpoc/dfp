<?php

namespace lispa\amos\audit\controllers;

use lispa\amos\audit\components\panels\RendersSummaryChartTrait;
use lispa\amos\audit\components\web\Controller;
use lispa\amos\audit\models\AuditEntry;
use Yii;

/**
 * DefaultController
 * @package lispa\amos\audit\controllers
 */
class DefaultController extends Controller
{
    use RendersSummaryChartTrait;

    /**
     * Module Default Action.
     * @return mixed
     */
    public function actionIndex()
    {
        $chartData = $this->getChartData();
        return $this->render('index', ['chartData' => $chartData]);
    }

    protected function getChartModel()
    {
        return AuditEntry::className();
    }
}
