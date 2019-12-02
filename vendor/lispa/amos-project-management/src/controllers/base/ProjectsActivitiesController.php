<?php

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\search\ProjectsActivitiesSearch;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * ProjectsActivitiesController implements the CRUD actions for ProjectsActivities model.
 */
class ProjectsActivitiesController extends CrudController
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
        $this->setModelObj(new ProjectsActivities());
        $this->setModelSearch(new ProjectsActivitiesSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
            'gantt' => [
                'name' => 'gantt',
                'label' => Module::t('amoscore', '{iconaGantt}' . Html::tag('p', Module::t('amoscore', 'Gantt')), [
                    'iconaGantt' => AmosIcons::show('view-list')
                ]),
                'url' => '?currentView=gantt'
            ],/*
            'list' => [
                'name' => 'list',
                'label' => Module::t('amoscore', '{iconaLista}'.Html::tag('p',Module::t('amoscore', 'List')), [
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
            /*'map' => [
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
//        $this->setUpLayout();
        \Yii::$app->view->params['forceCreateNewButtonWidget'] = true;
    }

    /**
     * Displays a single ProjectsActivities model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /** @var ProjectsActivities $model */
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * TODO Implemetare controllo accesso e creazione per progetto
     * Creates a new ProjectsActivities model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid)
    {
        $this->setUpLayout('form');
        $model = new ProjectsActivities();
        $model->attrProjectsMm = $pid;
        /** @var Projects $project */
        $project = Projects::findOne(['id' => $pid]);
        if (empty($project)) {
            throw new InvalidParamException('PID...');
        }

        if (!Yii::$app->user->can('PROJECTSACTIVITIES_CREATE')) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't create project activity because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        $query = $project->getCommunityUserMms()->andWhere([CommunityUserMm::tableName().'.status' => CommunityUserMm::STATUS_ACTIVE]);
        $partecipants = ArrayHelper::map($query->all(), 'user.id', 'user.userProfile.nomeCognome');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $ProjectsMmPost = \Yii::$app->request->post('ProjectsActivities')['attrProjectsMm'];

            $OrganizationMmPost = \Yii::$app->request->post('ProjectsActivities')['attrOrganizationMm'];
            $userMmPost = \Yii::$app->request->post('ProjectsActivities')['attrUserMm'];
            if ($model->save()) {

                if (!empty($ProjectsMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->projects_id = $ProjectsMmPost;
                    $newRelazioneMm->save(false);
                }
                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->user_id = $userMmPost;
                    $newRelazioneMm->save(false);
                }
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento creato correttamente.'));
                if(!empty($_POST['submit-button']) && $_POST['submit-button'] == 'save_and_close') {
                    return $this->redirect(['/project_management/projects/by-project', 'id' => $model->projects->id]);
                }
                return $this->redirect(['/project_management/projects-activities/update', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger',
                    Module::t('amoscore', 'Elemento non creato, verificare i dati inseriti.'));
                return $this->render('create', [
                    'model' => $model,
                    'project' => $project,
                    'fid' => null,
                    'pid' => $pid,
                    'dataField' => null,
                    'dataEntity' => null,
                    'partecipants' => $partecipants
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'project' => $project,
                'fid' => null,
                'pid' => $pid,
                'dataField' => null,
                'dataEntity' => null,
                'partecipants' => $partecipants
            ]);
        }
    }

    /**
     * Creates a new ProjectsActivities model by ajax request.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAjax($fid, $dataField)
    {
        $this->setUpLayout('form');
        $model = new ProjectsActivities();

        if (\Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) {

            $ProjectsMmPost = \Yii::$app->request->post('ProjectsActivities')['attrProjectsMm'];

            $OrganizationMmPost = \Yii::$app->request->post('ProjectsActivities')['attrOrganizationMm'];
            if ($model->save()) {

                if (!empty($ProjectsMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->projects_id = $ProjectsMmPost;
                    $newRelazioneMm->save(false);
                }

                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->save(false);
                }
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
     * Updates an existing ProjectsActivities model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        Url::remember();
        \Yii::$app->session->set('previousUrl', Url::current());
        $this->setUpLayout('form');
        /** @var ProjectsActivities $model */
        $model = $this->findModel($id);
        $project = $model->projects;

        if (!Yii::$app->user->can('PROJECTSACTIVITIES_UPDATE', ['model' => $model])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't update project activity because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        $model->attrProjectsMm = $model->projects;
        $model->attrOrganizationMm = $model->organization;
        $model->attrUserMm = $model->user;
        $pid = $project->id;

        $query = $project->getCommunityUserMms()->andWhere([CommunityUserMm::tableName().'.status' => CommunityUserMm::STATUS_ACTIVE]);
        $partecipants = ArrayHelper::map($query->all(), 'user.id', 'user.userProfile.nomeCognome');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $ProjectsMmPost = \Yii::$app->request->post('ProjectsActivities')['attrProjectsMm'];

            $OrganizationMmPost = \Yii::$app->request->post('ProjectsActivities')['attrOrganizationMm'];
            $UserMmPost = \Yii::$app->request->post('ProjectsActivities')['attrUserMm'];
            if ($model->save()) {

                \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm::deleteAll(['projects_activities_id' => $id]);
                if (!empty($ProjectsMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->projects_id = $ProjectsMmPost;
                    $newRelazioneMm->save(false);
                }

                \lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm::deleteAll(['projects_activities_id' => $id]);
                if (!empty($OrganizationMmPost)) {
                    $newRelazioneMm = new \lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm();
                    $newRelazioneMm->projects_activities_id = $model->id;
                    $newRelazioneMm->organization_id = $OrganizationMmPost;
                    $newRelazioneMm->user_id = $UserMmPost;
                    $newRelazioneMm->save(false);
                }
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Elemento aggiornato correttamente.'));
                if(!empty($_POST['submit-button']) && $_POST['submit-button'] == 'save_and_close') {
                    return $this->redirect(['/project_management/projects/by-project', 'id' => $model->projects->id]);
                }
                return $this->redirect(['/project_management/projects-activities/update', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non aggiornato, verificare i dati inseriti.'));
                return $this->render('update', [
                    'model' => $model,
                    'project' => $project,
                    'fid' => null,
                    'dataField' => null,
                    'dataEntity' => null,
                    'partecipants' => $partecipants,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'project' => $project,
                'fid' => null,
                'dataField' => null,
                'dataEntity' => null,
                'partecipants' => $partecipants,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectsActivities model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var ProjectsActivities $model */
        $model = $this->findModel($id);
        $project = $model->projects;

        if (!Yii::$app->user->can('PROJECTSACTIVITIES_DELETE', ['model' => $model])) {
            Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management', "You can't delete project activity because the projects is in status '{projectStatus}'", [
                'projectStatus' => Module::t('amosproject_management', $project->getWorkflowStatus()->getLabel())
            ]));
            return $this->redirect(['/project_management/projects/by-project', 'id' => $project->id]);
        }

        if ($model) {
            if ($model->projectsTasks) {
                Yii::$app->getSession()->addFlash('danger',
                    Module::t('amosproject_management', 'This activity contains Tasks'));
            } else {
                $model->delete();
                Yii::$app->getSession()->addFlash('success',
                    Module::t('amoscore', 'Elemento cancellato correttamente.'));
            }
        } else {
            Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non trovato.'));
        }
        return $this->redirect(Url::previous());
    }
}
