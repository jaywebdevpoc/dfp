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
use open20\amos\faq\models\FaqCategories;
use open20\amos\faq\models\FaqCategoriesSearch;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use open20\amos\faq\assets\AmosFaqAsset;

/**
 * Class FaqCategoriesController
 * FaqCategoriesController implements the CRUD actions for FaqCategories model.
 * @package open20\amos\faq\controllers
 */
class FaqCategoriesController extends CrudController
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
     */
    public function init()
    {
        $this->initDashboardTrait();

        $this->setModelObj(new FaqCategories());
        $this->setModelSearch(new FaqCategoriesSearch());

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
     * Lists all FaqCategories models.
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
     * Displays a single FaqCategories model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->setUpLayout('form');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new FaqCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $this->setUpLayout('form');
        $model = new FaqCategories;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FaqCategories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
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
     * Deletes an existing FaqCategories model.
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
