<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\community\models\search\CommunitySearch;
use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\search\OrganizationsSearch;
use lispa\amos\projectmanagement\models\search\ProjectsActivitiesSearch;
use lispa\amos\projectmanagement\models\search\ProjectsModifyRequestSearch;
use lispa\amos\projectmanagement\models\search\ProjectsProgressDetectionPeriodSearch;
use lispa\amos\projectmanagement\models\search\ProjectsSearch;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */

/**
 * Class ProjectsController
 * ProjectsController implements the CRUD actions for Projects model.
 *
 * @property \lispa\amos\projectmanagement\models\Projects $model
 *
 * @package lispa\amos\projectmanagement\controllers\base
 */
class ProjectsController extends CrudController
{
    /**
     * @var string $layout
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setModelObj(new Projects());
        $this->setModelSearch(new ProjectsSearch());

        $this->setAvailableViews([
            'list' => [
                'name' => 'list',
                'label' => Module::t('amoscore', '{iconaLista}' . Html::tag('p', Module::t('amoscore', 'List')), [
                    'iconaLista' => AmosIcons::show('view-list')
                ]),
                'url' => '?currentView=list'
            ],
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
            /*'icon' => [
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

    public function getActivityAvailableViews()
    {
        return [
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentViewActivities=grid'
            ],
            'gantt' => [
                'name' => 'gantt',
                'label' => Module::t('amoscore', '{iconaGantt}' . Html::tag('p', Module::t('amoscore', 'Gantt')), [
                    'iconaGantt' => AmosIcons::show('view-list')
                ]),
                'url' => '?currentViewActivities=gantt'
            ],
        ];
    }

    public function getCostsAvailableViews()
    {
        return [
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentViewCosts=grid'
            ],
        ];
    }

    public function getPeriodsAvailableViews()
    {
        return [
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentViewPeriods=grid'
            ],
        ];
    }

    public function getModifyRequestAvailableViews()
    {
        return [
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentViewModifyRequest=grid'
            ],
        ];
    }

    /**
     * This method returns all the workflow statuses for the Projects model ready to be used in a select widget.
     * @return array
     */
    public function getProjectsWorkflowStatusesForSelect()
    {
        $workflowStates = ProjectManagementUtility::getProjectsWorkflowStatusesForSelect();
        return $workflowStates;
    }

    /**
     * This method returns all the projects measures ready to be used in a select widget.
     * @return array
     */
    public function getProjectsMeasuresForSelect()
    {
        $values = ProjectManagementUtility::getProjectsMeasuresForSelect();
        return $values;
    }

    /**
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        \Yii::$app->view->params['createNewBtnParams'] = [
            'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Project'),
            'urlCreateNew' => '/project_management/new-project-wizard/from-community',
//            'otherOptions' => [
//                'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to create a project?')
//            ]
        ];
        return parent::actionIndex();
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionByProject($id = null, $pid = null, $currentViewActivities = 'grid', $currentViewCosts = 'grid', $currentViewPeriods = 'grid', $modifyRequestCurrentView = 'grid', $startProject = 0)
    {
        if (!empty($pid)) {
            $id = $pid;
        }
        $this->model = $this->findModel($id);

        /** the button in the green box */
        if ($startProject) {
            $this->model->setScenario(Projects::SCENARIO_CREATE_SAVE);
            if ($this->model->validate()) {
                $this->model->status = Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED;
                $this->model->save();
                \Yii::$app->session->addFlash('success', 'Progetto avviato correttamente');
            }
        }

        Url::remember();
        \Yii::$app->session->set('previousUrl', Url::current());

        $this->setUpLayout('main');
        $this->setCurrentView($this->getAvailableView('grid'));

        /** @var  $modifyRequestModelSearch ProjectsModifyRequestSearch */
        $modifyRequestModelSearch = new ProjectsModifyRequestSearch();
        $modifyRequestDataProvider = $modifyRequestModelSearch->search([]);

        $activitySearch = new ProjectsActivitiesSearch();
        $activities = $activitySearch->searchByProjects(['pid' => $this->model->id]);

        $dataProviderCosts = new \lispa\amos\projectmanagement\models\ItemWorkPlanDataProvider([
            'projectId' => $id,
            'pagination' => false,
        ]);

        $periodSearch = new ProjectsProgressDetectionPeriodSearch();
        $dataProviderPeriods = $periodSearch->search(['projects_id' => $id]);

        return $this->render('view_tabs', [
            'project' => $this->model,

            'modifyRequestDataProvider' => $modifyRequestDataProvider,
            'modifyRequestCurrentView' => $this->getModifyRequestAvailableViews()[$modifyRequestCurrentView],
            'modifyRequestAvailableViews' => $this->getModifyRequestAvailableViews(),

            'dataProviderActivities' => $activities,
            'currentViewActivities' => $this->getActivityAvailableViews()[$currentViewActivities],
            'availableViewsActivities' => $this->getActivityAvailableViews(),

            'dataProviderCosts' => $dataProviderCosts,
            'currentViewCosts' => $this->getCostsAvailableViews()[$currentViewCosts],
            'availableViewsCosts' => $this->getCostsAvailableViews(),

            'dataProviderPeriods' => $dataProviderPeriods,
            'currentViewPeriods' => $this->getPeriodsAvailableViews()[$currentViewPeriods],
            'availableViewsPeriods' => $this->getPeriodsAvailableViews(),
        ]);
    }

    /**
     * Displays a single Projects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->model = $this->findModel($id);

        /** @var  $modifyRequestModelSearch ProjectsModifyRequestSearch */
        $modifyRequestModelSearch = new ProjectsModifyRequestSearch();
        $modifyRequestDataProvider = $modifyRequestModelSearch->search([]);

        /** @var ActiveDataProvider $organizationActivities */
        $modelOrgSearch = new OrganizationsSearch();
        $organizationDataProvider = $modelOrgSearch->activitiesProjectSearch($this->model->id);

//        if ($this->model->load(Yii::$app->request->post()) && $this->model->save()) {
//            return $this->redirect(['view', 'id' => $this->model->id]);
//        } else {
        return $this->render('view', [
            'model' => $this->model,
            'modifyRequestDataProvider' => $modifyRequestDataProvider,
            'organizationDataProvider' => $organizationDataProvider
        ]);
//        }
    }

    /**
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->setUpLayout('form');
        $this->model = new Projects();

        $participantsDataProvider = null;
        $modifyRequestDataProvider = null;
        if (!$this->model->isNewRecord) {
            /** @var CommunitySearch $communitySearch */
            $communitySearch = CommunitySearch::findOne($this->model->community_id);
            $participantsDataProvider = $communitySearch->searchParticipants([]);
            /** @var  $modifyRequestModelSearch ProjectsModifyRequestSearch */
            $modifyRequestModelSearch = new ProjectsModifyRequestSearch();
            $modifyRequestDataProvider = $modifyRequestModelSearch->search([]);
        }
        /** @var ActiveDataProvider $organizationActivities */
        $modelOrgSearch = new OrganizationsSearch();
        $organizationDataProvider = $modelOrgSearch->activitiesProjectSearch($this->model->id);

        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {

//            $ProjectsStatesMmPost = \Yii::$app->request->post('Projects')['attrProjectsStatesMm'];
//            $OrganizationMmPost = \Yii::$app->request->post('Projects')['attrOrganizationMm'];
            $ProjectsMeasureMmPost = \Yii::$app->request->post('Projects')['attrProjectsMeasureMm'];

            $errorMessage = Module::t('amosproject_management', 'Elemento non creato, verificare i dati inseriti.');
            try {
                $ok = $this->model->save();
//                ProjectManagementUtility::duplicateLogoFromCommunity($community, $this->model,'communityLogo',Community::className());

            } catch (\Exception $exception) {
                $errorMessage = Module::t('amosproject_management',
                    'Elemento non creato. ' . $exception->getMessage() . '.');
                $ok = false;
            }

            if ($ok) {
//                if (!empty($ProjectsStatesMmPost)) {
//                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm();
//                    $newRelazioneMm->projects_id = $this->model->id;
//                    $newRelazioneMm->projects_states_id = $ProjectsStatesMmPost;
//                    $newRelazioneMm->save(false);
//                }

                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsOrganizationMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }

                /*f (!empty($JoinedOrganizationsMmPost)) {
                    foreach ((array)$JoinedOrganizationsMmPost as $relazionato) {
                        $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsOrganizationMm();
                        $newRelazioneMm->projects_id = $this->model->id;
                        $newRelazioneMm->organization_id = $relazionato;
                        $newRelazioneMm->save(false);
                    }
                }*/

                if (!empty($ProjectsMeasureMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->projects_measure_id = $ProjectsMeasureMmPost;
                    $newRelazioneMm->save(false);
                }

                Yii::$app->getSession()->addFlash('success',
                    Module::t('amosproject_management', 'Elemento creato correttamente.'));
                return $this->redirect(['update', 'id' => $this->model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger', $errorMessage);
                return $this->render('create', [
                    'model' => $this->model,
                    'fid' => null,
                    'dataField' => null,
                    'dataEntity' => null,
                    'participantsDataProvider' => $participantsDataProvider,
                    'organizationDataProvider' => $organizationDataProvider,
                    'modifyRequestDataProvider' => $modifyRequestDataProvider,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $this->model,
                'fid' => null,
                'dataField' => null,
                'dataEntity' => null,
                'participantsDataProvider' => $participantsDataProvider,
                'organizationDataProvider' => $organizationDataProvider,
                'modifyRequestDataProvider' => $modifyRequestDataProvider,
            ]);
        }
    }

    /**
     * Creates a new Projects model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->setUpLayout('form');
        $this->model = new Projects();

        if (\Yii::$app->request->isAjax && $this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
//            $ProjectsStatesMmPost = \Yii::$app->request->post('Projects')['attrProjectsStatesMm'];
            $OrganizationMmPost = \Yii::$app->request->post('Projects')['attrOrganizationMm'];
            //$JoinedOrganizationsMmPost = \Yii::$app->request->post('Projects')['attrJoinedOrganizationsMm'];
            $ProjectsMeasureMmPost = \Yii::$app->request->post('Projects')['attrProjectsMeasureMm'];
            if ($this->model->save()) {

//                if (!empty($ProjectsStatesMmPost)) {
//                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm();
//                    $newRelazioneMm->projects_id = $this->model->id;
//                    $newRelazioneMm->projects_states_id = $ProjectsStatesMmPost;
//                    $newRelazioneMm->save(false);
//                }

                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsOrganizationMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }

                /*if (!empty($JoinedOrganizationsMmPost)) {
                    foreach ((array)$JoinedOrganizationsMmPost as $relazionato) {
                        $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm();
                        $newRelazioneMm->projects_id = $this->model->id;
                        $newRelazioneMm->organization_id = $relazionato;
                        $newRelazioneMm->save(false);
                    }
                }*/

                if (!empty($ProjectsMeasureMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->projects_measure_id = $ProjectsMeasureMmPost;
                    $newRelazioneMm->save(false);
                }
                //Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento creato correttamente.'));
                return json_encode($this->model->toArray());
            } else {
                //Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                return $this->renderAjax('_formAjax', [
                    'model' => $this->model,
                    'fid' => $fid,
                    'dataField' => $dataField
                ]);
            }
        } else {
            return $this->renderAjax('_formAjax', [
                'model' => $this->model,
                'fid' => $fid,
                'dataField' => $dataField
            ]);
        }
    }

    /**
     * Updates an existing Projects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        Url::remember();

        $this->setUpLayout('form');
        $this->model = $this->findModel($id);

        $this->model->setScenario(Projects::SCENARIO_CREATE_SAVE);

        if (!Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $this->model])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'You are not authorized to update this element'));
            return $this->redirect(['view', 'id' => $this->model->id]);
        }

        $this->model->attrProjectsStatesMm = $this->model->projectsStates;
        $this->model->attrOrganizationMm = $this->model->organization;
        $this->model->attrJoinedOrganizationsMm = $this->model->joinedOrganizations;
        $this->model->attrProjectsMeasureMm = $this->model->projectsMeasure;

        /** @var CommunitySearch $communitySearch */
        $communitySearch = CommunitySearch::findOne($this->model->community_id);
        $participantsDataProvider = $communitySearch->searchParticipants([]);
        /** @var ActiveDataProvider $organizationActivities */
        $modelSearch = new OrganizationsSearch();
        $organizationDataProvider = $modelSearch->activitiesProjectSearch($this->model->id);
        /** @var  $modifyRequestModelSearch ProjectsModifyRequestSearch */
        $modifyRequestModelSearch = new ProjectsModifyRequestSearch();
        $modifyRequestDataProvider = $modifyRequestModelSearch->search([]);

        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {

            //if there is NO spending voices: write error end jump to the view
            if (count($this->model->projectsSpendingVoices) < 1) {
                $msg_validation_cost = Module::t('amosproject_management', '#validation_error_voci_spesa');
                Yii::$app->getSession()->addFlash('danger', $msg_validation_cost);
                goto render_update_view;
            }

//            $ProjectsStatesMmPost = \Yii::$app->request->post('Projects')['attrProjectsStatesMm'];
//            $OrganizationMmPost = \Yii::$app->request->post('Projects')['attrOrganizationMm'];
            //$JoinedOrganizationsMmPost = \Yii::$app->request->post('Projects')['attrJoinedOrganizationsMm'];
            $ProjectsMeasureMmPost = \Yii::$app->request->post('Projects')['attrProjectsMeasureMm'];

            $errorMessage = Module::t('amosproject_management', 'Elemento non aggiornato, verificare i dati inseriti.');
            try {
                $ok = $this->model->save();
            } catch (\Exception $exception) {
                $errorMessage = Module::t('amosproject_management', 'Elemento non aggiornato. ' . $exception->getMessage() . '.');
                $ok = false;
            }

            if ($ok) {
//                \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm::deleteAll(['projects_id' => $id]);
//                if (!empty($ProjectsStatesMmPost)) {
//                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm();
//                    $newRelazioneMm->projects_id = $this->model->id;
//                    $newRelazioneMm->projects_states_id = $ProjectsStatesMmPost;
//                    $newRelazioneMm->save(false);
//                }

                \lispa\amos\projectmanagement\models\ProjectsOrganizationMm::deleteAll(['projects_id' => $id]);
                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsOrganizationMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }

                /*\lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm::deleteAll(['projects_id' => $id]);
                if (!empty($JoinedOrganizationsMmPost)) {
                    foreach ($JoinedOrganizationsMmPost as $relazionato) {
                        $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm();
                        $newRelazioneMm->projects_id = $id;
                        $newRelazioneMm->organization_id = $relazionato;
                        $newRelazioneMm->save(false);
                    }
                }*/

                \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm::deleteAll(['projects_id' => $id]);
                if (!empty($ProjectsMeasureMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm();
                    $newRelazioneMm->projects_id = $this->model->id;
                    $newRelazioneMm->projects_measure_id = $ProjectsMeasureMmPost;
                    $newRelazioneMm->save(false);
                }
                Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', 'Elemento aggiornato correttamente.'));
                $redirectAction = (!Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $this->model]) ? 'view' : 'update');
                if(!empty($_POST['submit-button']) && $_POST['submit-button'] == 'save_and_close') {
                    return $this->redirect(['/project_management/projects/by-project', 'id' => $this->model->id]);
                }
                else {
                    return $this->redirect(['/project_management/projects/update', 'id' => $this->model->id]);
                }
            } else {
                Yii::$app->getSession()->addFlash('danger', $errorMessage);
            }
        }

        render_update_view:
        return $this->render('update', [
            'model' => $this->model,
            'fid' => null,
            'dataField' => null,
            'dataEntity' => null,
            'participantsDataProvider' => $participantsDataProvider,
            'organizationDataProvider' => $organizationDataProvider,
            'modifyRequestDataProvider' => $modifyRequestDataProvider,
        ]);
    }

    /**
     * Deletes an existing Projects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->model = $this->findModel($id);

        if (!Yii::$app->user->can('PROJECTS_DELETE', ['model' => $this->model])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'You are not authorized to delete this element'));
            return $this->redirect(['view', 'id' => $this->model->id]);
        }

        if ($this->model) {
//            $ok = true;
//            if (!is_null($this->model->community) && is_null($this->model->community->deleted_at)) {
            try {
                $this->model->delete();
            } catch (\Exception $exception) {
//                    $ok = false;
//                    Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'Errore durante la cancellazione della community del progetto.'));
                Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', 'Elemento cancellato correttamente.'));
            }
            if ($this->model->hasErrors()) {
//                    $ok = false;
//                    Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'Errore durante la cancellazione della community del progetto.'));
                Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'Errore durante la cancellazione.'));
            } else {
                Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', 'Elemento cancellato correttamente.'));
            }
//            }

//            if ($ok) {
//                $this->model->delete();
//                if (!$this->model->getErrors()) {
//                    Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management', 'Elemento cancellato correttamente.'));
//                } else {
//                    Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'Errore durante la cancellazione.'));
//                }
//            }
        } else {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', 'Elemento non trovato.'));
        }
        return $this->redirect(Url::previous());
    }
}
