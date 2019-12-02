<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\controllers
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\controllers;

use lispa\amos\core\forms\editors\m2mWidget\controllers\M2MWidgetControllerTrait;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksProjectsActivitiesMm;
use lispa\amos\projectmanagement\Module;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\CookieCollection;

/**
 * This is the class for controller "ProjectsActivitiesController".
 */
class ProjectsActivitiesController extends base\ProjectsActivitiesController
{
    /**
     * M2MWidgetControllerTrait
     */
    use M2MWidgetControllerTrait;

    private $pmWpViewCookie = 'pm-wp-current-view';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
//        $this->setUpLayout();

        $this->setMmTableName(ProjectsTasksProjectsActivitiesMm::className());
        $this->setStartObjClassName(ProjectsActivities::className());
        $this->setMmStartKey('projects_activities_id');
        $this->setTargetObjClassName(ProjectsTasks::className());
        $this->setMmTargetKey('projects_tasks_id');
        $this->setRedirectAction('update');
        //$this->setOptions(['tabActive' => 'tab-participants']);
        $this->setTargetUrl('associa_m2m');
        $this->setCustomQuery(true);
        /*$this->setMmTableAttributesDefault([
            'status' => CommunityUserMm::STATUS_INVITE_IN_PROGRESS,
            'role' => CommunityUserMm::ROLE_PARTICIPANT
        ]);*/
        $this->setModuleClassName(Module::className());

        // $this->on(M2MEventsEnum::EVENT_AFTER_ASSOCIATE_M2M, [$this, 'afterAssociateM2m']);
        \Yii::$app->view->params['forceCreateNewButtonWidget'] = true;
    }

    public function beforeAction($action)
    {
        if ($action->id == 'by-project') {
            $getTypeOfView = \Yii::$app->request->get('currentView');
            /** @var CookieCollection $cookies */
            $cookies = \Yii::$app->request->cookies;
            $cookieName = $this->pmWpViewCookie . '-' . \Yii::$app->request->get('pid');
            if (!empty($getTypeOfView)) {
                if ($cookies->has($cookieName)) {
                    \Yii::$app->response->cookies->remove($cookies[$cookieName]);
                }
                \Yii::$app->response->cookies->add(new Cookie([
                        'name' => $cookieName,
                        'value' => $getTypeOfView,
                        'expire' => time() + 2592000, // 30 days
                    ])
                );
            } else {
                if ($cookies->has($cookieName)) {
                    $getTypeOfView = $cookies->get($cookieName)->value;
                }
            }
            if (!empty($getTypeOfView)) {
                $this->currentView = $this->getAvailableView($getTypeOfView);
            }
        }
        return parent::beforeAction($action);
    }


    /**
     * Lists all ProjectsActivities models by Project.
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionByProject($pid)
    {
        return $this->redirect(['/project_management/projects/by-project/', 'id' => $pid]);


        if (empty($pid)) {
            throw new InvalidParamException();
        }

        Url::remember();
//        \Yii::$app->session->set('previousUrl', Url::current());

        \Yii::$app->view->params['createNewBtnParams'] = [
            'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Activity'),
            'urlCreateNew' => ['create', 'pid' => $pid],
            'checkPermWithNewMethod' => true,
            'model' => $this->model
        ];

        $this->setDataProvider($this->getModelSearch()->searchByProjects(\Yii::$app->request->getQueryParams()));
        $modelProject = Projects::findOne(['id' => $pid]);
        \Yii::$app->view->params['modelProject'] = $modelProject;

        $urlToModifyRequestIndex = null;
        if (in_array('COMMUNITY_MANAGER', $modelProject->getCommunityRoleByUser())) {
            $urlToModifyRequestIndex = ['/project_management/projects-modify-request/index', 'pid' => $pid];
        } else {
            $urlToModifyRequestIndex = ['/project_management/projects-modify-request/index-mine', 'pid' => $pid];
        }
        $urlToDetectionPeriodsIndex = ['/project_management/projects-progress-detection-period/index', 'pid' => $pid];
        $urlToProgressStatementIndex = ['/project_management/projects-progress-statements/index', 'pid' => $pid];
        $urlToProgressCostsIndex = ['/project_management/projects-progress-costs/index', 'pid' => $pid];

        \Yii::$app->view->params['urlToModifyRequestIndex'] = $urlToModifyRequestIndex;
        \Yii::$app->view->params['urlToDetectionPeriodsIndex'] = $urlToDetectionPeriodsIndex;
        \Yii::$app->view->params['urlToProgressStatementIndex'] = $urlToProgressStatementIndex;
        \Yii::$app->view->params['urlToProgressCostsIndex'] = $urlToProgressCostsIndex;

        return parent::actionIndex();
    }

    /**
     * Lists all ProjectsActivities models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();
        $this->setUpLayout('list');

        //se il layout di default non dovesse andar bene si può aggiuntere il layout desiderato
        //in questo modo nel controller "return parent::actionIndex($this->layout);"
        if ($layout) {
            $this->layout = $layout;
        }

        $cwhVars = \Yii::$app->session->get('cwh-relation-table');

        $project = Projects::findOne(['community_id' => $cwhVars['entity_id']]);

        \Yii::$app->view->params['modelProject'] = $project;

        if (!$project || !$project->id) {
            return $this->redirect('/project-management');
        }

        return $this->redirect(['/project_management/projects/by-project', 'pid' => $project->id]);
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
        $module = \Yii::$app->getModule('layout');
        if (empty($module)) {
            $this->layout = '@vendor/lispa/amos-core/views/layouts/' . (!empty($layout) ? $layout : $this->layout);
            return true;
        }
        $this->layout = (!empty($layout)) ? $layout : $this->layout;

//        pr($this->layout);
//        die;
        return true;
    }

    /**
     * @param AmosModule $moduleCwh
     * @param string $classname
     * @return bool
     */
    private function isSetCwh($moduleCwh, $classname)
    {
        if (isset($moduleCwh) && in_array($classname, $moduleCwh->modelsEnabled)) {
            return true;
        } else {
            return false;
        }
    }
}
