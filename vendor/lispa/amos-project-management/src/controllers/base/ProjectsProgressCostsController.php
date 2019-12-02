<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsProgressCosts;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\search\ProjectsProgressCostsSearch;
use Yii;
use lispa\amos\core\controllers\CrudController;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\helpers\Html;
use yii\helpers\Url;

/**
 * ProjectsProgressCostsController implements the CRUD actions for ProjectsProgressCosts model.
 */
class ProjectsProgressCostsController extends CrudController
{
    public function init()
    {
        $this->setModelObj(new ProjectsProgressCosts());
        $this->setModelSearch(new ProjectsProgressCostsSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Yii::t('amoscore', '{iconaTabella}' . Html::tag('p', Yii::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
            /*'list' => [
                'name' => 'list',
                'label' => Yii::t('amoscore', '{iconaLista}'.Html::tag('p',Yii::t('amoscore', 'List')), [
                    'iconaLista' => AmosIcons::show('view-list')
                ]),           
                'url' => '?currentView=list'
            ],
            'icon' => [
                'name' => 'icon',
                'label' => Yii::t('amoscore', '{iconaElenco}'.Html::tag('p',Yii::t('amoscore', 'Icons')), [
                    'iconaElenco' => AmosIcons::show('grid')
                ]),           
                'url' => '?currentView=icon'
            ],
            'map' => [
                'name' => 'map',
                'label' => Yii::t('amoscore', '{iconaMappa}'.Html::tag('p',Yii::t('amoscore', 'Map')), [
                    'iconaMappa' => AmosIcons::show('map')
                ]),       
                'url' => '?currentView=map'
            ],
            'calendar' => [
                'name' => 'calendar',
                'intestazione' => '', //codice HTML per l'intestazione che verrà caricato prima del calendario,
                                      //per esempio si può inserire una funzione $model->getHtmlIntestazione() creata ad hoc
                'label' => Yii::t('amoscore', '{iconaCalendario}'.Html::tag('p',Yii::t('amoscore', 'Calendar')), [
                    'iconaMappa' => AmosIcons::show('calendar')
                ]),       
                'url' => '?currentView=calendar'
            ],*/
        ]);

        parent::init();
    }

    /**
     * Lists all ProjectsProgressCosts models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($layout = NULL, $pid = null)
    {
        $projects = $this->checkProjectExist($pid);
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        $this->setUpLayout('form');
//        if ($layout) {
//            $this->setUpLayout($layout);
//        }
        return $this->render('index', [
            'projects' => $projects,
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : NULL,
            'parametro' => ($this->parametro) ? $this->parametro : NULL
        ]);
    }

    /**
     * Displays a single ProjectsProgressCosts model.
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
     * Creates a new ProjectsProgressCosts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->setUpLayout('form');
        $model = new ProjectsProgressCosts;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item created'));
                return $this->redirect(['index']);
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
     * Updates an existing ProjectsProgressCosts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        //POII-1100 - layout main to obtain comments section as in view
        $this->setUpLayout('main');
        /** @var ProjectsProgressCosts $model */
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item updated'));
                return $this->redirect(['/project_management/projects/by-project', 'id' => $model->projectsProgressDetectionPeriod->projects_id, '#' => 'costs']);
            } else {
                Yii::$app->getSession()->addFlash('danger', Yii::t('amoscore', 'Item not updated, check data'));
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectsProgressCosts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            //si può sostituire il  delete() con forceDelete() in caso di SOFT DELETE attiva
            //In caso di soft delete attiva e usando la funzione delete() non sarà bloccata
            //la cancellazione del record in presenza di foreign key quindi
            //il record sarà cancelleto comunque anche in presenza di tabelle collegate a questo record
            //e non saranno cancellate le dipendenze e non avremo nemmeno evidenza della loro presenza
            //In caso di soft delete attiva è consigliato modificare la funzione oppure utilizzare il forceDelete() che non andrà
            //mai a buon fine in caso di dipendenze presenti sul record da cancellare
            if ($model->delete()) {
                Yii::$app->getSession()->addFlash('success', Yii::t('amoscore', 'Item deleted'));
            } else {
                // Yii::$app->getSession()->addFlash('danger', Yii::t('amoscore', 'Item not deleted because of dependency'));
            }
        } else {
            Yii::$app->getSession()->addFlash('danger', Yii::t('amoscore', 'Item not found'));
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $pid
     * @return Projects
     */
    private function checkProjectExist($pid)
    {
        /** @var Projects $projects */
        $projects = Projects::findOne($pid);
        if (empty($projects)) {
            throw new InvalidParamException();
        }
        return $projects;
    }

    /**
     * Lists all ProjectsProgressCosts models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionHistoryActivity($tid = null)
    {
        $this->setUpLayout('main');
        $task = ProjectsTasks::findOne($tid);
        if (empty($task)) {
            throw new InvalidParamException();
        }

        //POII-1054 view in history only if in status confirmed
        $query = $task->getProjectsProgressCosts()->andWhere(['status' =>  ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED]);
        $statementActual = $task->progressCost;
        if (!empty($statementActual)){
            $query->andWhere(['NOT IN','id', $statementActual->id]);
        }
        $query->orderBy('last_confirmed_time ASC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        return $this->render('history_activity', [
            'task' => $task,
            'dataProvider' => $dataProvider,
        ]);
    }
}
