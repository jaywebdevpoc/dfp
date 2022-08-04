<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\risultati\controllers\base;

use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\helpers\T;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\dashboard\controllers\TabDashboardControllerTrait;
use lispa\amos\risultati\AmosRisultati;
use lispa\amos\risultati\models\ProtezioneInnovazioneRisultati;
use lispa\amos\risultati\models\search\ProtezioneInnovazioneRisultatiSearch;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class ProtezioneInnovazioneRisultatiController
 * ProtezioneInnovazioneRisultatiController implements the CRUD actions for ProtezioneInnovazioneRisultati model.
 * @package lispa\amos\risultati\controllers\base
 */
class ProtezioneInnovazioneRisultatiController extends CrudController
{
    /**
     * Uso il trait per inizializzare la dashboard a tab
     */
    use TabDashboardControllerTrait;

    /**
     * @var string $layout
     */
    public $layout = 'list';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->initDashboardTrait();

        $this->setModelObj(new ProtezioneInnovazioneRisultati());
        $this->setModelSearch(new ProtezioneInnovazioneRisultatiSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => T::tApp('{iconaTabella}' . Html::tag('p', 'Tabella'), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
            /*'list' => [
                'name' => 'list',
                'label' => T::tApp('{iconaLista}'.Html::tag('p','Lista'), [
                    'iconaLista' => AmosIcons::show('view-list')
                ]),           
                'url' => '?currentView=list'
            ],
            'icon' => [
                'name' => 'icon',
                'label' => T::tApp('{iconaElenco}'.Html::tag('p','Icone'), [
                    'iconaElenco' => AmosIcons::show('grid')
                ]),           
                'url' => '?currentView=icon'
            ],
            'map' => [
                'name' => 'map',
                'label' => T::tApp('{iconaMappa}'.Html::tag('p','Mappa'), [
                    'iconaMappa' => AmosIcons::show('map')
                ]),       
                'url' => '?currentView=map'
            ],
            'calendar' => [
                'name' => 'calendar',
                'intestazione' => '', //codice HTML per l'intestazione che verrà caricato prima del calendario,
                                      //per esempio si può inserire una funzione $model->getHtmlIntestazione() creata ad hoc
                'label' => T::tApp('{iconaCalendario}'.Html::tag('p','Calendario'), [
                    'iconaMappa' => AmosIcons::show('calendar')
                ]),       
                'url' => '?currentView=calendar'
            ],*/
        ]);

        parent::init();
        $this->setUpLayout();
    }

    /**
     * Lists all ProtezioneInnovazioneRisulta models.
     * @return mixed
     */
    public function actionIndex($layout = NULL)
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        return parent::actionIndex();
    }

    /**
     * Displays a single ProtezioneInnovazioneRisulta model.
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
     * Finds the ProtezioneInnovazioneRisulta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProtezioneInnovazioneRisultati the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProtezioneInnovazioneRisultati::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(AmosRisultati::t('amosrisultati', 'La pagina richiesta non è disponibile'));
        }
    }

    /**
     * Creates a new ProtezioneInnovazioneRisulta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = new ProtezioneInnovazioneRisultati;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', AmosRisultati::t('amosrisultati', 'Elemento creato correttamente.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->addFlash('danger', AmosRisultati::t('amosrisultati', 'Elemento non creato, verificare i dati inseriti.'));
                return $this->render('create', [
                    'model' => $model,
                    'fid' => NULL,
                    'dataField' => NULL,
                    'dataEntity' => NULL,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'fid' => NULL,
                'dataField' => NULL,
                'dataEntity' => NULL,
            ]);
        }
    }

    /**
     * Creates a new ProtezioneInnovazioneRisulta model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = new ProtezioneInnovazioneRisultati;

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                //Yii::$app->getSession()->addFlash('success', AmosRisultati::t('amosrisultati', 'Elemento creato correttamente.'));
                return json_encode($model->toArray());
            } else {
                //Yii::$app->getSession()->addFlash('danger', AmosRisultati::t('amosrisultati', 'Elemento non creato, verificare i dati inseriti.'));
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
     * Updates an existing ProtezioneInnovazioneRisulta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->addFlash('success', AmosRisultati::t('amosrisultati', 'Elemento aggiornato correttamente.'));
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->addFlash('danger', AmosRisultati::t('amosrisultati', 'Elemento non aggiornato, verificare i dati inseriti.'));
                return $this->render('update', [
                    'model' => $model,
                    'fid' => NULL,
                    'dataField' => NULL,
                    'dataEntity' => NULL,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'fid' => NULL,
                'dataField' => NULL,
                'dataEntity' => NULL,
            ]);
        }
    }

    /**
     * Deletes an existing ProtezioneInnovazioneRisulta model.
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
            Yii::$app->getSession()->addFlash('success', AmosRisultati::t('amosrisultati', 'Elemento cancellato correttamente.'));
        } else {
            Yii::$app->getSession()->addFlash('danger', AmosRisultati::t('amosrisultati', 'Elemento non trovato.'));
        }
        return $this->redirect(['index']);
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
