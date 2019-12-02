<?php

namespace lispa\amos\audit\controllers;

use lispa\amos\audit\components\web\Controller;
use lispa\amos\audit\models\AuditJavascript;
use lispa\amos\audit\models\AuditJavascriptSearch;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * JavascriptController
 * @package lispa\amos\audit\controllers
 */
class JavascriptController extends Controller
{
    /**
     * Lists all AuditJavascript models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuditJavascriptSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }

    /**
     * Displays a single AuditJavascript model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = AuditJavascript::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested javascript does not exist.');
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }
}
