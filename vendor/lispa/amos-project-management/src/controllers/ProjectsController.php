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

use lispa\amos\admin\models\UserProfile;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\forms\editors\m2mWidget\controllers\M2MWidgetControllerTrait;
use lispa\amos\core\forms\editors\m2mWidget\M2MEventsEnum;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\user\User;
use lispa\amos\core\utilities\Email;
use lispa\amos\dashboard\controllers\TabDashboardControllerTrait;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices;
use lispa\amos\projectmanagement\models\ProjectsJoinedOrganizationsMm;
use lispa\amos\projectmanagement\models\ProjectsSpendingVoices;
use lispa\amos\projectmanagement\models\ProjectsUserMm;
use lispa\amos\projectmanagement\models\search\OrganizationsSearch;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconMyProjects;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconOwnProjects;
use lispa\amos\projectmanagement\widgets\ProjectSpendingVoicesWidget;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * This is the class for controller "ProjectsController".
 */
class ProjectsController extends base\ProjectsController
{
    /**
     * Uso il trait per inizializzare la dashboard a tab
     */
    use TabDashboardControllerTrait;

    /**
     * M2MWidgetControllerTrait
     */
    use M2MWidgetControllerTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initDashboardTrait();

        /** @var Module $organizationModule */
        $organizationModule = Module::instance()->getModuleOrganization();
        $organizationModelClass = $organizationModule->getOrganizationModelClass();
//
        $this->setMmTableName(ProjectsJoinedOrganizationsMm::className());
        $this->setStartObjClassName(Projects::className());
        $this->setMmStartKey('projects_id');
        $this->setTargetObjClassName($organizationModelClass);
        $this->setMmTargetKey('organization_id');
        $this->setRedirectAction('update');
        $this->setOptions(['#' => 'tab-organizations']);
        $this->setTargetUrl('associa_m2m');
        $this->setCustomQuery(true);
        $this->setModuleClassName(Module::className());

        $this->on(M2MEventsEnum::EVENT_BEFORE_CANCEL_ASSOCIATE_M2M, [$this, 'beforeCancelAssociateM2m']);
    }

    public function beforeAction($action)
    {
        if ($action->id == 'update') {
            if (strpos(\Yii::$app->request->referrer, 'project_management/projects/update') === false) {
                \Yii::$app->session->set(Projects::SESSION_UPDATE_REFERER, \Yii::$app->request->referrer);
            }
        }
        return parent::beforeAction($action);
    }


    /**
     * Configure the m2mwidget to work with associate cost
     */
    public function configureAssociateCostItems()
    {
        $this->setMmTableName(ProjectsCustomSpendingVoices::className());
        $this->setStartObjClassName(Projects::className());
        $this->setMmStartKey('projects_id');
        $this->setTargetObjClassName(ProjectsSpendingVoices::className());
        $this->setMmTargetKey('spending_voice_parent_id');
        $this->setRedirectAction('update');
//        $this->setOptions(['#' => 'tab-cost-items']);
        $this->setTargetUrl('associate_spending_voices');
        $this->setCustomQuery(true);
        $this->setModuleClassName(Module::className());

    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionAssociateCostItems($id)
    {
        $this->configureAssociateCostItems();
        Url::remember();
        return $this->actionAssociaM2m($id);
    }

    /**
     * @param $event
     */
    public function beforeCancelAssociateM2m($event)
    {
        $urlPrevious = Url::previous();
        $projectId = \Yii::$app->request->get('id');
        if (strstr($urlPrevious, 'associate-cost-items')) {
            $this->setRedirectArray('/project_management/projects/update?id=' . $projectId . '#tab-cost-items');
        }
    }

    /**
     * @param $id
     * @param $targetId
     * @return \yii\web\Response
     */
    public function actionDeleteCostM2m($id, $targetId)
    {
        $this->configureAssociateCostItems();
        $this->setMmTargetKey('id');

        if(!$this->model->load(\Yii::$app->request->post())){
            $this->model = $this->findModel($id);
        }
        if ($this->model->hasLinkedCosts($targetId)) {
            $message = Module::t('amosproject_management', 'This Cost Item Is Not Empty');
//            if(\Yii::$app->request->isPost){
//                return $message;
//            }
            \Yii::$app->session->addFlash('danger', $message);
            return $this->redirect(['update', 'id' => $id]);
        }


        return $this->actionEliminaM2m($id, $targetId);
    }

    /**
     * @param $id
     * @param $targetId
     * @return void|\yii\web\Response
     */
    public function actionDeleteJoinedOrganizationM2m($id, $targetId)
    {
        $project = $this->findModel($id);

        if ($project->organization && $project->organization->id == $targetId) {
            \Yii::$app->session->addFlash('danger',
                Module::t('amosproject_management', 'You can\'t delete the reference organization'));

            return $this->redirect($this->getRedirectArray($id));
        }

        foreach ($project->projectsSpendingVoices as $spendingVoice) {
            $costRow = $project->getCostRow($spendingVoice->id, $targetId);

            if ($costRow && !empty($costRow['valueSumm'])) {
                \Yii::$app->session->addFlash('danger',
                    Module::t('amosproject_management', 'This Organization Has Assigned Budget'));

                return $this->redirect(['update', 'id' => $project->id, '#' => 'tab-organizations']);
            }
        }

        return $this->actionEliminaM2m($id, $targetId);
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
                            'associa-m2m',
                            'additional-associa-m2m',
                            'annulla-m2m',
                            'elimina-m2m',
                            'view',
                            'index',
                            'by-project'
                        ],
                        'roles' => ['PROJECT_MANAGER']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'update',
                            'spending-voices'
                        ],
                        'roles' => ['PROJECTS_UPDATE']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'own-projects',
                        ],
                        'roles' => ['PARTNER_REFERENT']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get']
                ]
            ]
        ]);
        return $behaviors;
    }

    /**
     * Method to view all projects
     *
     * @return string
     */
    public function actionIndex($layout = null)
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchMyProjects(\Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(WidgetIconMyProjects::widgetLabel());
    }

    /**
     * Method to view all projects
     *
     * @return string
     */
    public function actionOwnProjects($layout = null)
    {
        Url::remember();
        $this->setUpLayout('list');
        $this->setDataProvider($this->getModelSearch()->searchOwnProjects(\Yii::$app->request->getQueryParams()));

        $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        $this->view->params['forceCreateNewButtonWidget'] = true;
        \Yii::$app->view->params['createNewBtnParams'] = [
            'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Project'),
            'urlCreateNew' => '/project_management/new-project-wizard/wizard',
//            'otherOptions' => [
//                'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to create a project?')
//            ]
        ];
        $this->setListsBreadcrumbs(WidgetIconOwnProjects::widgetLabel());
        return $this->render('own_projects', [
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : null,
            'parametro' => ($this->parametro) ? $this->parametro : null
        ]);
    }

    /**
     * Gets the list of all projects created by the logged user
     *
     * @return string
     */
    public function actionCreatedByProjects()
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchCreatedByProjects(\Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(WidgetIconCreatedByProjects::widgetLabel());
    }

    /**
     * Gets the list of all projects to which the logged user is registered
     *
     * @return string
     */
    public function actionMyProjects()
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchMyProjects(\Yii::$app->request->getQueryParams()));
        return $this->baseListsAction(WidgetIconMyProjects::widgetLabel());
    }

    /**
     * Used to set page title and breadcrumbs.
     *
     * @param string $pageTitle Page title (ie. Created by, ...)
     */
    private function setListsBreadcrumbs($pageTitle)
    {
        \Yii::$app->session->set('previousTitle', $pageTitle);
        \Yii::$app->session->set('previousUrl', Url::previous());
        $translatedTitle = Module::t('amosproject_management', $pageTitle);
        \Yii::$app->view->title = $translatedTitle;
        \Yii::$app->view->params['breadcrumbs'] = [
            ['label' => $translatedTitle],
        ];
    }

    /**
     * Base operations in order to render different list views
     *
     * @return string
     */
    private function baseListsAction($pageTitle, $action = 'index')
    {
        Url::remember();
        $this->setCreateNewButton();

        $this->setUpLayout('list');
        $this->view->params['currentDashboard'] = $this->getCurrentDashboard();
        $this->setListsBreadcrumbs($pageTitle);
        return $this->render($action, [
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : null,
            'parametro' => ($this->parametro) ? $this->parametro : null
        ]);
    }

    /**
     * Redraw widget spending voices in project form
     * @param $id - int project Id
     * @return string the html code to render
     */
    public function actionSpendingVoices($id){

        $this->model = $this->findModel($id);
        $this->setUpLayout(false);
        $spendingSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
            Module::t('amosproject_management', '#project_update_spending') .
            '</h2></div>' . '<p>' . Module::t('amosproject_management', '#project_update_spending_subtitle1') . '</p>' .
            ProjectSpendingVoicesWidget::widget(['model' => $this->model]);
        return $spendingSection;
    }

    /**
     * @return \yii\web\Response
     */
    public function actionNew()
    {
        return $this->redirect('create');
    }


    public function actionSubscribe()
    {
        $projectId = \Yii::$app->request->get('projectId');
        $project = Projects::findOne($projectId);
        /** @var User $user */
        $user = User::findOne(\Yii::$app->getUser()->id);
        $userId = $user->id;
        $communityId = $project->community_id;

        $defaultAction = ['view', 'id' => $projectId];

        if (!$communityId) {
            \Yii::$app->getSession()->addFlash('danger', Module::tHtml('amosproject_management',
                "It is not possible to subscribe the user. Missing parameter community."));
            return $this->redirect($defaultAction);
        }

        /////////////////////////////////////////////////////
        // User joins Community
        $communityUserMm = new CommunityUserMm();
        $communityUserMm->community_id = $communityId;
        $communityUserMm->user_id = $userId;
        $communityUserMm->status = CommunityUserMm::STATUS_WAITING_OK_COMMUNITY_MANAGER;
        $communityUserMm->role = Projects::ROLE_PARTICIPANT;
        if ($communityUserMm->save()) {
            \Yii::$app->getSession()->addFlash('success', Module::t('amosproject_management',
                'Your request has been forwarded to projects manager for approval.'));
        } else {
            \Yii::$app->getSession()->addFlash('danger', Module::t('amosproject_management',
                'An error occurred. Your request has NOT been forwarded to projects manager for approval'));
        }

        /////////////////////////////////////////////////////
        // Send email to projects manager

        // Default email values
        $from = $user->email;
        $to = $communityUserMm->getCommunityManagerMailList($project->community_id);
        /** @var UserProfile $userProfile */
        $userProfile = $user->getProfile();
        // Populate SUBJECT
        $subject = Module::t('amosproject_management',
                'User') . ' ' . $userProfile->getNomeCognome() . ' ' . Module::t('amosproject_management',
                'asked to join the projects') . ' ' . $project->name;

        // Populate TEXT
        $text = $subject;
        $text .= Module::t('amosproject_management', 'Title') . ': ' . $project->name . '<br>';
        $text .= Module::t('amosproject_management', 'Summary') . ': ' . $project->summary . '<br>';
        $text .= Module::t('amosproject_management',
                'Published by') . ': ' . UserProfile::findOne(['user_id' => $project->created_by])->getNomeCognome();
        $createUrlParams = [
            '/project_management/projects/view',
            'id' => $projectId
        ];
        $url = \Yii::$app->urlManager->createAbsoluteUrl($createUrlParams) . '#tab-participants';
        $text .= Html::a(Module::t('amosproject_management', "Sign into the projects to accept or reject the request."),
            $url);

        $files = [];
        $bcc[] = $user->email;
        $params = null;
        $priority = 0;
        $use_queue = false;

        // SEND EMAIL
        Email::sendMail(
            $from,
            $to,
            $subject,
            $text,
            $files,
            $bcc,
            $params,
            $priority,
            $use_queue
        );

        return $this->redirect($defaultAction);
    }

    /**
     * @param $id Projects
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAssociateUserRoles($id)
    {
        $this->layout = '@vendor/lispa/amos-core/views/layouts/form';
        $project = Projects::findOne($id);
        $model = new ProjectsUserMm();
        $model->projects_id = $id;

        if (empty($project)) {
            throw new NotFoundHttpException();
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                \Yii::$app->session->addFlash('success', Module::t('amosproject_management', 'Elemento creato correttamente'));
                return $this->redirect(['update', 'id' => $id]);
            }
        }
        $userAssociated = \lispa\amos\projectmanagement\models\ProjectsUserMm::find()->andWhere(['projects_id' => $id])->all();
        $idUserAssociated = [];
        /** @var  $projectUsermm \lispa\amos\projectmanagement\models\ProjectsUserMm */
        foreach ($userAssociated as $projectUsermm) {
            $idUserAssociated [] = $projectUsermm->user_id;
        }
        return $this->render('associate_user_roles', ['model' => $model, 'idUserAssociated' => $idUserAssociated]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionModifyUserRoles($id)
    {
        $this->layout = '@vendor/lispa/amos-core/views/layouts/form';
        $model = ProjectsUserMm::findOne($id);

        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                return $this->render('associate_user_roles', ['model' => $model]);
            }
        }

        return $this->render('associate_user_roles', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteUserRoles($id)
    {
        $this->layout = '@vendor/lispa/amos-core/views/layouts/form';
        $model = ProjectsUserMm::findOne($id);

        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $project_id = $model->projects_id;
        $model->delete();
        return $this->redirect(['update', 'id' => $project_id]);
    }


    public function actionUserOrganizations()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $user_id = $parents[0];
                $modelSearch = new OrganizationsSearch();
                $dataProvider = $modelSearch->userOrganizationsSearch($user_id);
                if ($user_id == '') {
                    return Json::encode(['output' => '', 'selected' => '']);
                }
                $selected = '';
                $organizations = $dataProvider->query->all();
                foreach ($organizations as $org) {
                    $out [] = ['id' => $org->id, 'name' => $org->name];
                    if ((isset($_POST['depdrop_all_params']['organization-sel-id'])) && ($org->id == $_POST['depdrop_all_params']['organization-sel-id'])) {
                        $selected = $org->id;
                    }
                }
                return Json::encode(['output' => $out, 'selected' => $selected]);
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * @param null $layout
     * @return bool
     */
    public function setUpLayout($layout = null)
    {
        if ($layout === false) {
            $this->layout = false;
            return true;
        }
        $this->layout = (!empty($layout)) ? $layout : $this->layout;
        $module = \Yii::$app->getModule('layout');
        if (empty($module)) {
            if (strpos($this->layout, '@') === false) {
                $this->layout = '@vendor/lispa/amos-core/views/layouts/' . (!empty($layout) ? $layout : $this->layout);
            }
            return true;
        }
        return true;
    }

    public static function transarray($array)
    {

        foreach ($array as $key => $value) {
            $array[$key] = Module::t('amosproject_management', $value);
        }

        return $array;
    }

    /**
     *
     */
    public function setCreateNewButton(){
        $idCommunity = null;
        $moduleCwh = \Yii::$app->getModule('cwh');
        if (isset($moduleCwh) && !empty($moduleCwh->getCwhScope())) {
            $scope = $moduleCwh->getCwhScope();
            if (isset($scope['community'])) {
                $idCommunity = $scope['community'];
            }
        }
        \Yii::$app->view->params['createNewBtnParams'] = [
            'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Project'),
            'urlCreateNew' => ['/project_management/new-project-wizard/from-community', 'id' => $idCommunity],
        ];
    }

}
