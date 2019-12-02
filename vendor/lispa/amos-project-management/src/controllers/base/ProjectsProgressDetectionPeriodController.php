<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;
use Yii;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\search\ProjectsProgressDetectionPeriodSearch;
use lispa\amos\core\controllers\CrudController;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\helpers\T;
use yii\helpers\Url;

/**
 * ProjectsProgressDetectionPeriodController implements the CRUD actions for ProjectsProgressDetectionPeriod model.
 */
class ProjectsProgressDetectionPeriodController extends CrudController
{

    public function init()
    {
        $this->setModelObj(new ProjectsProgressDetectionPeriod());
        $this->setModelSearch(new ProjectsProgressDetectionPeriodSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Yii::t('amoscore', '{iconaTabella}' . Html::tag('p', Yii::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
    }

    /**
     * Lists all ProjectsProgressDetectionPeriod models.
     * @param null $layout
     * @param $pid
     * @return mixed
     */
    public function actionIndex($layout = NULL, $pid = null)
    {
        $this->setUpLayout('list');
        if ($layout) {
            $this->setUpLayout($layout);
        }

        $projects = $this->checkProjectExist($pid);
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchByProject(Yii::$app->request->getQueryParams(), $pid));

        \Yii::$app->view->params['createNewBtnParams'] = [
            'urlCreateNew' => ['create', 'pid' => $projects->id],
        ];
        \Yii::$app->view->params['projects'] = $projects;

        return $this->render('index', [
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : NULL,
        ]);
    }

    /**
     * Displays a single ProjectsProgressDetectionPeriod model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new ProjectsProgressDetectionPeriod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid)
    {
        $projects = $this->checkProjectExist($pid);

        $this->setUpLayout('form');
        $model = new ProjectsProgressDetectionPeriod;
        $model->projects_id = $projects->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item created'));
                return $this->redirect(['/project_management/projects/by-project','pid' => $pid, '#' => 'detection-periods']);
            } else {
                Yii::$app->getSession()->addFlash('danger', Yii::t('amoscore', 'Item not created, check data'));
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ProjectsProgressDetectionPeriod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param $pid
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id,$pid)
    {
        $projects = $this->checkProjectExist($pid);

        $this->setUpLayout('form');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item updated'));
                return $this->redirect(['/project_management/projects/by-project','id' => $pid, '#' => 'detection-periods']);
            } else {
                Yii::$app->getSession()->addFlash('danger', Yii::t('amoscore', 'Item not updated, check data'));
                return $this->render('update', [
                    'model' => $model,
                    'projects' => $projects,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'projects' => $projects,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectsProgressDetectionPeriod model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        /** @var ProjectsProgressDetectionPeriod $model */
        $model = $this->findModel($id);
        if ($model) {
            $pid = $model->projects_id;
            $model->delete();
            if (!empty($model->deleted_at)) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item deleted'));
            }
            return $this->redirect(['/project_management/projects/by-project','pid' => $pid, '#' => 'detection-periods']);
        } else {
            throw new InvalidParamException();
        }

    }

    /**
     * @param $pid
     * @return Projects
     */
    private function checkProjectExist($pid){
        /** @var Projects $projects */
        $projects = Projects::findOne($pid);
        if (empty($projects)){
            throw new InvalidParamException();
        }
        return $projects;
    }
}
