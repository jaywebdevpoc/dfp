<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksOrganizationMm;
use lispa\amos\projectmanagement\models\ProjectsTasksProjectsActivitiesMm;
use lispa\amos\projectmanagement\models\ProjectsTasksTasksMm;
use lispa\amos\projectmanagement\models\search\ProjectsTasksSearch;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class ProjectsTasksController
 * ProjectsTasksController implements the CRUD actions for ProjectsTasks model.
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsTasks $model
 *
 * @package lispa\amos\projectmanagement\controllers\base
 */
class ProjectsTasksController extends CrudController
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
        $this->setModelObj(new ProjectsTasks());
        $this->setModelSearch(new ProjectsTasksSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
        $this->setUpLayout();
        \Yii::$app->view->params['createNewBtnParams'] = [
            'checkPermWithNewMethod' => true,
            'model' => $this->model
        ];
        \Yii::$app->view->params['forceCreateNewButtonWidget'] = true;
    }

    /**
     * Displays a single ProjectsTasks model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->model = $this->findModel($id);

        if ($this->model->load(Yii::$app->request->post()) && $this->model->save()) {
            return $this->redirect(['view', 'id' => $this->model->id]);
        } else {
            return $this->render('view', ['model' => $this->model]);
        }
    }

    /**
     * TODO implementare controllo sui permessi di creazione per l'attività scelta in get
     * Creates a new ProjectsTasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($activity_id, $task_id = null)
    {
        $this->setUpLayout('form');
        $this->model = new ProjectsTasks();
        $this->model->attrProjectsActivitiesMm = $activity_id;
        $activity = ProjectsActivities::findOne(['id' => $activity_id]);
        $project = $activity->projects;

        if (!Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't create project task because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        $this->model->duration_scale = 'days';
        $this->model->start_date = $project->start_date;

        /** @var array $partecipants */
        $query = $project->getCommunityUserMms()->andWhere([CommunityUserMm::tableName() . '.status' => CommunityUserMm::STATUS_ACTIVE]);
        $partecipants = ArrayHelper::map($query->all(), 'user.id', 'user.userProfile.nomeCognome');

        if ($this->model->load(Yii::$app->request->post())) {
            if ($this->model->validate()) {
                if ($this->model->save()) {
                    $this->updateRelations($this->model, $task_id);
                    Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento creato correttamente.'));
                    if (!empty(Yii::$app->request->post('submit-button')) && (Yii::$app->request->post('submit-button') == 'save_and_close')) {
                        return $this->redirect(['/project_management/projects/by-project', 'id' => $this->model->project->id]);
                    } else {
                        return $this->redirect(['update', 'id' => $this->model->id]);
                    }
                } else {
                    Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                }
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                if (Yii::$app->request->post()[$this->model->formName()]['attrOrganizationMm']) {
                    $this->model->attrOrganizationMm = Yii::$app->request->post()[$this->model->formName()]['attrOrganizationMm'];
                }
            }
        }

        return $this->render('create', [
            'model' => $this->model,
            'activity' => $activity,
            'fid' => null,
            'aid' => $activity_id,
            'dataField' => null,
            'dataEntity' => null,
            'partecipants' => $partecipants
        ]);
    }

    /**
     * Creates a new ProjectsTasks model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->setUpLayout('form');
        $this->model = new ProjectsTasks();

        if (\Yii::$app->request->isAjax && $this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            if ($this->model->save()) {
                $this->updateRelations($this->model);
                return json_encode($this->model->toArray());
            } else {
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
     * Updates an existing ProjectsTasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $this->setUpLayout('form');
        $this->model = $this->findModel($id);
        $activity = $this->model->projectsActivities;
        $project = $activity->projects;

        if (!Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't update project task because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        $pid = $this->model->projectsActivities->projects->id;
        $this->model->attrProjectsActivitiesMm = $this->model->projectsActivities;
        $this->model->attrOrganizationMm = $this->model->organization;
        $this->model->attrUserMm = $this->model->user;

        //$this->model->attrProjectsTaskStatusesMm = $this->model->projectsTaskStatuses;

        $query = $project->getCommunityUserMms()->andWhere([CommunityUserMm::tableName() . '.status' => CommunityUserMm::STATUS_ACTIVE]);
        $partecipants = ArrayHelper::map($query->all(), 'user.id', 'user.userProfile.nomeCognome');

        Yii::$app->view->params['readOnlyNonTaskCostsTabs'] = $this->readOnlyNonTaskCostsTabs();
        if ($this->readOnlyNonTaskCostsTabs()) {
            $this->model->setScenario(ProjectsTasks::SCENARIO_COSTS_CREATOR);
        }
        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            $relationType = \Yii::$app->request->post('relationType');

            if ($this->model->save()) {
                $this->updateRelations($this->model);

                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm();
                    $newRelazioneMm->projects_activities_id = $this->model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    if (!(empty($userMmPost))) {
                        $newRelazioneMm->user_id = $userMmPost;
                    }
                    $newRelazioneMm->save(false);
                }

                if ($relationType) {
                    foreach ($relationType as $relId => $type) {
                        $mmRecord = ProjectsTasksTasksMm::findOne(['id' => $relId, 'tasks_id' => $this->model->id]);

                        if ($mmRecord) {
                            $mmRecord->type = $type;
                            $mmRecord->save();
                        }
                    }
                }
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento aggiornato correttamente.'));
                if (!empty(Yii::$app->request->post('submit-button')) && (Yii::$app->request->post('submit-button') == 'save_and_close')) {
                    return $this->redirect(['/project_management/projects/by-project', 'id' => $this->model->project->id]);
                } else {
                    return $this->redirect(['update', 'id' => $this->model->id]);
                }
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non aggiornato, verificare i dati inseriti.'));
            }
        }

        return $this->render('update', [
            'model' => $this->model,
            'activity' => $activity,
            'fid' => null,
            'pid' => $pid,
            'dataField' => null,
            'dataEntity' => null,
            'partecipants' => $partecipants
        ]);

    }

    /**
     * @return bool
     */
    public function readOnlyNonTaskCostsTabs()
    {
        $loggedUser = Yii::$app->getUser();
        $isReadOnly = false;
        if ($loggedUser->can('COSTS_CREATOR')) {
            $isReadOnly = true;
            $pluginRolesToCheck = [
                'PROJECT_MANAGER',
            ];
            foreach ($pluginRolesToCheck as $pluginRole) {
                if ($loggedUser->can($pluginRole)) {
                    $isReadOnly = false;
                }
            }
        }
        return $isReadOnly;
    }

    /**
     * @param ProjectsTasks $model
     * @param int $task_id
     */
    public function updateRelations($model, $task_id = null)
    {

        $projectsTaskCosts = \Yii::$app->request->post('projects_tasks_costs');

        //Store the costs from post data
        $model->storeNewCosts($projectsTaskCosts);

        if (!$this->readOnlyNonTaskCostsTabs()) {
            $ProjectsActivitiesMmPost = \Yii::$app->request->post('ProjectsTasks')['attrProjectsActivitiesMm'];
            $OrganizationMmPost = isset(\Yii::$app->request->post('ProjectsTasks')['attrOrganizationMm']) ? \Yii::$app->request->post('ProjectsTasks')['attrOrganizationMm'] : [];
            $UserMmPost = \Yii::$app->request->post('ProjectsTasks')['attrUserMm'];
            ProjectsTasksProjectsActivitiesMm::deleteAll(['projects_tasks_id' => $model->id]);
            if (!empty($ProjectsActivitiesMmPost)) {
                $newRelazioneMm = new ProjectsTasksProjectsActivitiesMm();
                $newRelazioneMm->projects_tasks_id = $model->id;
                $newRelazioneMm->projects_activities_id = $ProjectsActivitiesMmPost;
                $newRelazioneMm->save(false);
            }

            ProjectsTasksOrganizationMm::deleteAll(['projects_tasks_id' => $model->id]);
            if (!empty($OrganizationMmPost)) {
                $newRelazioneMm = new ProjectsTasksOrganizationMm();
                $newRelazioneMm->projects_tasks_id = $model->id;
                $newRelazioneMm->user_id = $UserMmPost;
                $newRelazioneMm->organization_id = $OrganizationMmPost;

                //pr($newRelazioneMm->attributes, '$newRelazioneMm'); die;

                $newRelazioneMm->save(false);
            }

            if (!empty($task_id)) {
                $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsTasksTasksMm();
                $newRelazioneMm->projects_tasks_id = $task_id;
                $newRelazioneMm->tasks_id = $model->id;
                $newRelazioneMm->save(false);
            }

            if (!empty($OrganizationMmPost)) {
                $joinedOrganizationsQuery = $model->getJoinedOrganizations();
                $joinedOrganizationsQuery->andWhere(['id' => $OrganizationMmPost]);

                $organizationExists = $joinedOrganizationsQuery->one();

                if (!$organizationExists || !$organizationExists->id) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsTasksJoinedOrganizationsMm();
                    $newRelazioneMm->projects_tasks_id = $model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }
            }
        }
    }

    /**
     * Deletes an existing ProjectsTasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->model = $this->findModel($id);
        $project = $this->model->projectsActivities->projects;

        if (!Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't delete project task because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        if ($this->model) {
            if ($this->model->requiredTasks || $this->model->inverseRequiredTasksMms) {
                if ($this->model->requiredTasks) {
                    Yii::$app->getSession()->addFlash('danger',
                        Module::t('amosproject_management', 'This Task has requirements'));
                }
                if ($this->model->inverseRequiredTasksMms) {
                    Yii::$app->getSession()->addFlash('danger',
                        Module::t('amosproject_management', 'This Task Is Required By Other Task'));
                }
            } else {
                $this->model->delete();
                Yii::$app->getSession()->addFlash('success',
                    Module::t('amoscore', 'Elemento cancellato correttamente.'));
            }
        } else {
            Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non trovato.'));
        }
        return $this->redirect(Url::previous());
    }
}
