<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\helpers\T;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\ProjectsTaskStatuses;
use lispa\amos\projectmanagement\models\search\ProjectsTaskStatusesSearch;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * ProjectsTaskStatusesController implements the CRUD actions for ProjectsTaskStatuses model.
 */
class ProjectsTaskStatusesController extends CrudController
{
    /**
     * @var string $layout
     */
    public $layout = 'list';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setModelObj(new ProjectsTaskStatuses());
        $this->setModelSearch(new ProjectsTaskStatusesSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
            /*'list' => [
                'name' => 'list',
                'label' => Module::t('amoscore', '{iconaLista}'.Html::tag('p',Module::t('amoscore', 'Lista')), [
                    'iconaLista' => AmosIcons::show('view-list')
                ]),           
                'url' => '?currentView=list'
            ],
            'icon' => [
                'name' => 'icon',
                'label' => Module::t('amoscore', '{iconaElenco}'.Html::tag('p',Module::t('amoscore', 'Icons')), [
                    'iconaElenco' => AmosIcons::show('grid')
                ]),           
                'url' => '?currentView=icon'
            ],
            'map' => [
                'name' => 'map',
                'label' => Module::t('amoscore', '{iconaMappa}'.Html::tag('p',Module::t('amoscore', 'Map')), [
                    'iconaMappa' => AmosIcons::show('map')
                ]),       
                'url' => '?currentView=map'
            ],
            'calendar' => [
                'name' => 'calendar',
                'intestazione' => '', //codice HTML per l'intestazione che verrà caricato prima del calendario,
                                      //per esempio si può inserire una funzione $model->getHtmlIntestazione() creata ad hoc
                'label' => Module::t('amoscore', '{iconaCalendario}'.Html::tag('p',Module::t('amoscore', 'Calendario')), [
                    'iconaMappa' => AmosIcons::show('calendar')
                ]),       
                'url' => '?currentView=calendar'
            ],*/
        ]);

        parent::init();
        $this->setUpLayout();
    }

    /**
     * Lists all ProjectsTaskStatuses models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        return parent::actionIndex();
    }

    /**
     * Displays a single ProjectsTaskStatuses model.
     * @param integer $id
     * @return mixed
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
     * Creates a new ProjectsTaskStatuses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->setUpLayout('form');
        $model = new ProjectsTaskStatuses;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento creato correttamente.'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger',
                    Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                return $this->render('create', [
                    'model' => $model,
                    'fid' => null,
                    'dataField' => null,
                    'dataEntity' => null,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'fid' => null,
                'dataField' => null,
                'dataEntity' => null,
            ]);
        }
    }

    /**
     * Creates a new ProjectsTaskStatuses model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->setUpLayout('form');
        $model = new ProjectsTaskStatuses;

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
//Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento creato correttamente.'));
                return json_encode($model->toArray());
            } else {
//Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                return $this->renderAjax('_formAjax', [
                    'model' => $model,
                    'fid' => $fid,
                    'dataField' => $dataField
                ]);
            }
        } else {
            return $this->renderAjax('_formAjax', [
                'model' => $model,
                'fid' => $fid,
                'dataField' => $dataField
            ]);
        }
    }

    /**
     * Updates an existing ProjectsTaskStatuses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->setUpLayout('form');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success',
                    Module::t('amoscore', 'Elemento aggiornato correttamente.'));
                return $this->redirect(['update', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger',
                    Module::t('amoscore', 'Elemento non aggiornato, verificare i dati inseriti.'));
                return $this->render('update', [
                    'model' => $model,
                    'fid' => null,
                    'dataField' => null,
                    'dataEntity' => null,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'fid' => null,
                'dataField' => null,
                'dataEntity' => null,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectsTaskStatuses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
            $model->delete();
            Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento cancellato correttamente.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non trovato.'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the ProjectsTaskStatuses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProjectsTaskStatuses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProjectsTaskStatuses::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
            $this->layout =  '@vendor/lispa/amos-core/views/layouts/' . (!empty($layout) ? $layout : $this->layout);
            return true;
        }
        $this->layout = (!empty($layout)) ? $layout : $this->layout;
        return true;
    }
}
