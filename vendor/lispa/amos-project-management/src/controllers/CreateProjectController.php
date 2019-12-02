<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\controllers;

use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\components\CreateProject;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\search\ProjectsSearch;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CreateProjectController extends CrudController
{
    /**
     * @var string $layout
     */
    public $layout = 'progress_wizard';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setModelObj(new Projects());
        $this->setModelSearch(new ProjectsSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => AmosIcons::show('view-list-alt') . Html::tag('p', Module::t('amoscommunity', 'Table')),
                'url' => '?currentView=grid'
            ],
            'icon' => [
                'name' => 'icon',
                'label' => AmosIcons::show('grid') . Html::tag('p', Module::t('amoscommunity', 'Icons')),
                'url' => '?currentView=icon'
            ],
        ]);

        parent::init();
        $this->setUpLayout();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'info',
                            'organizations',
                            'test',
                        ],
                        'roles' => ['@']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get'],
                ]
            ]
        ]);
        return $behaviors;
    }

    /**
     * Creates an array of parameters to pass to progress-wizard layout
     *
     * @return array $params contains the model to work on and the parts (steps) of progress-wizard to follow for community form
     */
    private function getParamsForView()
    {
        $params = [
            'model' => $this->model,
            'partsQuestionario' => new CreateProject([
                'project' => $this->model,
            ])
        ];
        return $params;
    }

    /**
     * Redirects to the next step of community progress-wizard form
     * @return \yii\web\Response
     */
    public function goToNextPart()
    {
        $partsQuestionario = new CreateProject([
            'project' => $this->model,
        ]);

        return $this->redirect([
            $partsQuestionario->getNext(),
            'id' => $this->model->id
        ]);
    }

    /**
     * Renders Introductory step of project crearion progress-wizard form
     *
     * @param $id integer - id of community model
     * @return string|\yii\web\Response
     */
    public function actionIndex($id = null)
    {
        Url::remember();

        if (isset($id)) {
            $this->model = $this->findModel($id);
        } elseif (!$this->model) {
            $this->model = new Projects();
        }

        $this->model->attrProjectsStatesMm = $this->model->projectsStates;

        $this->model->attrOrganizationMm = $this->model->organization;

        $this->model->attrProjectsMeasureMm = $this->model->projectsMeasure;

        if ($this->model->load(Yii::$app->getRequest()->post())) {
            $ProjectsStatesMmPost = \Yii::$app->request->post('Projects')['attrProjectsStatesMm'];
            $OrganizationMmPost = \Yii::$app->request->post('Projects')['attrOrganizationMm'];
            $ProjectsMeasureMmPost = \Yii::$app->request->post('Projects')['attrProjectsMeasureMm'];

            if ($this->model->save()) {
                if (!empty($ProjectsStatesMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->projects_states_id = $ProjectsStatesMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsOrganizationMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($ProjectsMeasureMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->projects_measure_id = $ProjectsMeasureMmPost;
                    $newRelazioneMm->save(false);
                }

                return $this->goToNextPart();
            }
        }

        Yii::$app->view->params = $this->getParamsForView();

        return $this->render('intro', [
            'model' => $this->model,
        ]);
    }

    public function actionOrganizations($id = null)
    {
        Url::remember();

        if (isset($id)) {
            $this->model = $this->findModel($id);
        } else {
            $this->model = new Projects();
            //$this->model->status = Projects::;
        }

        $this->model->attrJoinedOrganizationsMm = $this->model->joinedOrganizations;

        if (Yii::$app->getRequest()->post('Projects') && $this->model) {
            $JoinedOrganizationsMmPost = \Yii::$app->request->post('Projects')['attrJoinedOrganizationsMm'];

            if (!empty($JoinedOrganizationsMmPost)) {
                foreach ((array)$JoinedOrganizationsMmPost as $relazionato) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->organization_id = $relazionato;
                    $newRelazioneMm->save(false);
                }

                return $this->goToNextPart();
            }
        }

        Yii::$app->view->params = $this->getParamsForView();

        return $this->render('organizations', [
            'model' => $this->model,
        ]);
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