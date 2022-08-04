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

use open20\amos\core\controllers\CrudController;
use open20\amos\core\helpers\Html;
use open20\amos\core\icons\AmosIcons;
use open20\amos\dashboard\controllers\TabDashboardControllerTrait;
use open20\amos\faq\AmosFaq;
use open20\amos\faq\models\FaqStato;
use open20\amos\faq\models\FaqStatoSearch;
use open20\amos\faq\assets\AmosFaqAsset;
use Yii;
use yii\helpers\Url;

/**
 * Class FaqStatoController
 * FaqStatoController implements the CRUD actions for FaqStato model.
 * @package open20\amos\faq\controllers
 */
class FaqStatoController extends CrudController
{
    /**
     * Trait used for initialize the tab dashboard
     */
    use TabDashboardControllerTrait;

    /**
     * @var string $layout
     */
    public $layout = 'list';

    /**
     * @inheritdoc
     */public function init() {
        $this->initDashboardTrait();
        $this->setModelObj(new FaqStato());
        $this->setModelSearch(new FaqStatoSearch());
        AmosFaqAsset::register(Yii::$app->view);
        $this->setAvailableViews([
            /* 'map' => [
              'name' => 'map',
              'label' => AmosFaq::t('amosfaq', '{iconaMappa}'.Html::tag('p',AmosFaq::t('amosfaq', 'Mappa')), [
              'iconaMappa' => AmosIcons::show('map-alt')
              ]),
              'url' => '?currentView=map'
              ], */
            'grid' => [
                'name' => 'grid',
                'label' => AmosFaq::t('amosfaq', '{iconaTabella}' . Html::tag('p', AmosFaq::t('amosfaq', 'Tabella')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
        $this->setUpLayout();
    }

    /**
     * Lists all FaqStato models.
     * @return mixed
     */
    public function actionIndex($layout = NULL)
    {
        Url::remember();

        $this->setUpLayout('list');
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        return parent::actionIndex();
    }

    /**
     * Displays a single FaqStato model.
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
     * Creates a new FaqStato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->setUpLayout('form');
        $model = new FaqStato;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FaqStato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->setUpLayout('form');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FaqStato model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
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
            $this->layout =  '@vendor/open20/amos-core/views/layouts/' . (!empty($layout) ? $layout : $this->layout);
            return true;
        }
        $this->layout = (!empty($layout)) ? $layout : $this->layout;
        return true;
    }
}
