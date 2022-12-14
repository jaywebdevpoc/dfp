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
use lispa\amos\risultati\models\Risultati;
use lispa\amos\risultati\models\RisultatiBisognoPerSviluppoRisultatiMm;
use lispa\amos\risultati\models\RisultatiProtezioneInnovazioneRisultatiMm;
use lispa\amos\risultati\models\RisultatiStadioSviluppoRisultatiMm;
use lispa\amos\risultati\models\RisultatiTecnologieRisultatiMm;
use lispa\amos\risultati\models\search\RisultatiSearch;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class RisultatiController
 * RisultatiController implements the CRUD actions for Risultati model.
 * @package lispa\amos\risultati\controllers\base
 */
class RisultatiController extends CrudController
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

        $this->setModelObj(new Risultati());
        $this->setModelSearch(new RisultatiSearch());

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
                'intestazione' => '', //codice HTML per l'intestazione che verr?? caricato prima del calendario,
                                      //per esempio si pu?? inserire una funzione $model->getHtmlIntestazione() creata ad hoc
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
     * Lists all Risultati models.
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
     * Displays a single Risultati model.
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
     * Finds the Risultati model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Risultati the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Risultati::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(AmosRisultati::t('amosrisultati', 'La pagina richiesta non ?? disponibile'));
        }
    }

    /**
     * Creates a new Risultati model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = new Risultati;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $TecnologieRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrTecnologieRisultatiMm'];
            $StadioSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrStadioSviluppoRisultatiMm'];
            $ProtezioneInnovazioneRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrProtezioneInnovazioneRisultatiMm'];
            $BisognoPerSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrBisognoPerSviluppoRisultatiMm'];
            if ($model->save()) {

                if (!empty($TecnologieRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiTecnologieRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->tecnologie_risultati_id = $TecnologieRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($StadioSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiStadioSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->stadio_sviluppo_risultati_id = $StadioSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($ProtezioneInnovazioneRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiProtezioneInnovazioneRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->protezione_innovazione_risultati_id = $ProtezioneInnovazioneRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($BisognoPerSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiBisognoPerSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->bisogno_per_sviluppo_risultati_id = $BisognoPerSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }
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
     * Creates a new Risultati model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = new Risultati;

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $TecnologieRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrTecnologieRisultatiMm'];
            $StadioSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrStadioSviluppoRisultatiMm'];
            $ProtezioneInnovazioneRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrProtezioneInnovazioneRisultatiMm'];
            $BisognoPerSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrBisognoPerSviluppoRisultatiMm'];
            if ($model->save()) {

                if (!empty($TecnologieRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiTecnologieRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->tecnologie_risultati_id = $TecnologieRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($StadioSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiStadioSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->stadio_sviluppo_risultati_id = $StadioSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($ProtezioneInnovazioneRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiProtezioneInnovazioneRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->protezione_innovazione_risultati_id = $ProtezioneInnovazioneRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($BisognoPerSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiBisognoPerSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->bisogno_per_sviluppo_risultati_id = $BisognoPerSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }
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
     * Updates an existing Risultati model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "@vendor/lispa/amos-core/views/layouts/form";
        $model = $this->findModel($id);
        $model->attrTecnologieRisultatiMm = $model->tecnologieRisultati;
        $model->attrStadioSviluppoRisultatiMm = $model->stadioSviluppoRisultati;
        $model->attrProtezioneInnovazioneRisultatiMm = $model->protezioneInnovazioneRisultati;
        $model->attrBisognoPerSviluppoRisultatiMm = $model->bisognoPerSviluppoRisultati;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $TecnologieRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrTecnologieRisultatiMm'];
            $StadioSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrStadioSviluppoRisultatiMm'];
            $ProtezioneInnovazioneRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrProtezioneInnovazioneRisultatiMm'];
            $BisognoPerSviluppoRisultatiMmPost = \Yii::$app->request->post('Risultati')['attrBisognoPerSviluppoRisultatiMm'];
            if ($model->save()) {

                RisultatiTecnologieRisultatiMm::deleteAll(['risultati_id' => $id]);
                if (!empty($TecnologieRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiTecnologieRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->tecnologie_risultati_id = $TecnologieRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                RisultatiStadioSviluppoRisultatiMm::deleteAll(['risultati_id' => $id]);
                if (!empty($StadioSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiStadioSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->stadio_sviluppo_risultati_id = $StadioSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                RisultatiProtezioneInnovazioneRisultatiMm::deleteAll(['risultati_id' => $id]);
                if (!empty($ProtezioneInnovazioneRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiProtezioneInnovazioneRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->protezione_innovazione_risultati_id = $ProtezioneInnovazioneRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }

                RisultatiBisognoPerSviluppoRisultatiMm::deleteAll(['risultati_id' => $id]);
                if (!empty($BisognoPerSviluppoRisultatiMmPost)) {
                    $newRelazioneMm = new RisultatiBisognoPerSviluppoRisultatiMm();
                    $newRelazioneMm->risultati_id = $model->id;
                    $newRelazioneMm->bisogno_per_sviluppo_risultati_id = $BisognoPerSviluppoRisultatiMmPost;
                    $newRelazioneMm->save(false);
                }
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
     * Deletes an existing Risultati model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            //si pu?? sostituire il  delete() con forceDelete() in caso di SOFT DELETE attiva
            //In caso di soft delete attiva e usando la funzione delete() non sar?? bloccata
            //la cancellazione del record in presenza di foreign key quindi
            //il record sar?? cancelleto comunque anche in presenza di tabelle collegate a questo record
            //e non saranno cancellate le dipendenze e non avremo nemmeno evidenza della loro presenza
            //In caso di soft delete attiva ?? consigliato modificare la funzione oppure utilizzare il forceDelete() che non andr??
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
