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

use lispa\amos\core\forms\CreateNewButtonWidget;
use lispa\amos\core\forms\editors\m2mWidget\controllers\M2MWidgetControllerTrait;
use lispa\amos\core\forms\editors\m2mWidget\M2MEventsEnum;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksJoinedOrganizationsMm;
use lispa\amos\projectmanagement\models\ProjectsTasksTasksMm;
use lispa\amos\projectmanagement\Module;
use kartik\grid\GridView;
use Yii;
use yii\helpers\Url;

/**
 * This is the class for controller "ProjectsTasksController".
 */
class ProjectsTasksController extends base\ProjectsTasksController
{
    /**
     * @var bool
     */
    const ERROR_RELATION_START_TO_START = 1;
    const ERROR_RELATION_FINISH_TO_FINISH = 2;

    /**
     * M2MWidgetControllerTrait
     */
    use M2MWidgetControllerTrait;

    /**
     * Initialize m2m configuration default
     */
    public function init()
    {
        parent::init();
        $this->setUpLayout();

        $this->setMmTableName(ProjectsTasksTasksMm::className());
        $this->setStartObjClassName(ProjectsTasks::className());
        $this->setMmStartKey('tasks_id');
        $this->setTargetObjClassName(ProjectsTasks::className());
        $this->setMmTargetKey('projects_tasks_id');
        $this->setRedirectAction('update');
        $this->setOptions(['#' => 'tab-dependencies']);
        $this->setTargetUrl('associa_m2m');
        $this->setCustomQuery(true);
        $this->setModuleClassName(Module::className());

        $this->on(M2MEventsEnum::EVENT_BEFORE_CANCEL_ASSOCIATE_M2M, [$this, 'beforeCancelAssociateM2m']);
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

    /**
     * @param $event
     */
    public function beforeCancelAssociateM2m($event)
    {
        $urlPrevious = Url::previous();
        $taskId = \Yii::$app->request->get('id');
        if (strstr($urlPrevious, 'add-organization')) {
            $this->setRedirectArray('/project_management/projects-tasks/update?id=' . $taskId . '#tab-organizations');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionAddOrganization($id)
    {
        $this->configureAssociateOrganization();
        return $this->actionAssociaM2m($id);
    }

    /**
     * Configure the m2mwidget to work with participant organizations
     */
    public function configureAssociateOrganization()
    {
        $className = Module::getModuleOrganization()->getOrganizationModelClass();
        Url::remember();
        $this->setMmTableName(ProjectsTasksJoinedOrganizationsMm::className());
        $this->setStartObjClassName(ProjectsTasks::className());
        $this->setMmStartKey('projects_tasks_id');
        $this->setTargetObjClassName($className::className());
        $this->setMmTargetKey('organization_id');
        $this->setRedirectAction('update');
        $this->setOptions(['#' => 'tab-organizations']);
        $this->setTargetUrl('add_organization');
        $this->setCustomQuery(true);
        $this->setModuleClassName(Module::className());

    }

    /**
     * @param $id
     * @param $targetId
     */
    public function actionDeleteOrganization($id, $targetId)
    {
        $this->configureAssociateOrganization();
        $taskId = \Yii::$app->request->get('id');
        $orgId = \Yii::$app->request->get('targetId');
        $task = ProjectsTasks::findOne($taskId);
        if($task){
            if(!empty($task->organization) && $task->organization->id == $orgId){
                Yii::$app->session->addFlash('danger', "Non è possibile eliminare l'organizzazione responsabile");
                return $this->redirect('/project_management/projects-tasks/update?id=' . $taskId . '#tab-organizations');
            }
        }

        return $this->actionEliminaM2m($id, $targetId);

    }

    /**
     * Lists all ProjectsActivities models by Project.
     * @return mixed
     */
    public function actionByActivity()
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->searchByActivity(\Yii::$app->request->getQueryParams()));
        return parent::actionIndex();
    }

    /**
     * Lists all ProjectsTasks models.
     * @return mixed
     */
    public function actionIndex($layout = null)
    {
        Url::remember();
        $this->setDataProvider($this->getModelSearch()->search(\Yii::$app->request->getQueryParams()));
        return parent::actionIndex();
    }

    public function actionListOnly()
    {
        $expandRowKey = \Yii::$app->request->post('expandRowKey');
        $projectActivity = ProjectsActivities::findOne($expandRowKey);
        $project = $projectActivity->projects;

        \Yii::$app->request->setQueryParams(['aid' => $expandRowKey]);


        $dataProvider = $this->getModelSearch()->searchByActivity(\Yii::$app->request->getQueryParams());
        $dataProvider->sort = false;

        /** @var Module $projectManagementModule */
        $projectManagementModule = \Yii::$app->getModule('project_management');

        try {
            $createBtn = '';
            if (Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])) {
                $createBtn = CreateNewButtonWidget::widget([
                    'model' => $this->model,
                    'createNewBtnLabel' => Module::t('amosproject_management', 'Create Task'),
                    'urlCreateNew' => ['/project_management/projects-tasks/create', 'activity_id' => $expandRowKey],
                    'btnClasses' => 'btn btn-success pull-right'
                ]);
            }

            return GridView::widget([
                'id' => 'product-gridview',
                'dataProvider' => $dataProvider,
                'responsive' => true,
                'export' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'options' => [
                        'id' => 'product-grid',
                        'timeout' => (isset(\Yii::$app->params['timeout']) ? \Yii::$app->params['timeout'] : $projectManagementModule->timeout),
                        'enablePushState' => false
                    ]
                ],
                'columns' => [
                    [
                        'attribute' => 'checkStatus',
                        'format' => 'raw',
                        'label' => Module::t('amosproject_management', 'Status'),
                        'value' => function ($model, $index, $dataColumn) {
                            /**
                             * @var $model ProjectsTasks
                             */
                            $error = $model->getHasDependencyError(true);
                            if ($error) {
                                $taskDependency = $model->getFirstDependencyTaskError(true);
                                $icon = 'alert-triangle';
                                $class = 'text-danger';
                                $message = self::getRelationError($error, $taskDependency);
                            } else {
                                $icon = 'check-circle';
                                $class = 'text-success';
                                $message = Module::t('amosproject_management', 'Ok');
                            }
                            return AmosIcons::show($icon, ['data-toggle' => "tooltip", 'title' => $message, 'class' => $class . '', 'style' => 'font-size: 25px;']);
                        },
                    ],
                    [
                        'class' => 'yii\grid\DataColumn',
                        'attribute' => 'name',
                        'label' => Module::t('amosproject_management', 'Task Title')
                    ],
                    'start_date:date',
                    'endDate:date',
//                    [
//                        'class' => 'yii\grid\DataColumn',
//                        'attribute' => 'projectsTaskStatuses.name',
//                        'label' => Module::t('amosproject_management', 'Status')
//                    ],
                    'expDuration',
                    'referent' => [
                        'attribute' => 'userReferent',
                        'label' => Module::t('amosproject_management', 'Reference User'),
                    ],
                    'referentOrg' => [
                        'attribute' => 'organizationReferentName',
                        'label' => Module::t('amosproject_management', 'Reference Organization'),
                    ],
                    //
                    //                'tasks' => [
                    //                    'attribute' => 'tasks',
                    //                    'format' => 'html',
                    //                    'label' => 'Dependencies',
                    //                    'value' => function ($model) {
                    //                        return strip_tags($model->getAttrTasksMm(','));
                    //                    }
                    //                ],
                    [
                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
                    ],
                ],
                'panel' => [
                    'before' => false,
                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i>&nbsp;' . Module::t('amosproject_management', 'Tasks') . '</h3>' . $createBtn,
                    'type' => 'success',
                    'after' => false,
                    //Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
                    'footer' => false
                ],
            ]);
        } catch (\Exception $e) {
            pr($e->getTraceAsString());
            return $e->getMessage();
        }
    }

    /**
     * Ajax call from font end to calculate end date of a task from start date, duration, scale
     * @return string Json
     */
    public function actionCalculateEndDate()
    {
        $retval = [];
        if (Yii::$app->getRequest()->getIsAjax()) {
            $post = Yii::$app->getRequest()->post();
            if (!empty($post['changedId'])) {
                $changedId = $post['changedId'];
            }
            $beginDate = null;
            if (!empty($post['beginDate'])) {
                $beginDate = $post['beginDate'];
            }
            $lengthValue = null;
            if (!empty($post['lengthValue'])) {
                $lengthValue = $post['lengthValue'];
            }
            $lengthMUId = null;
            if (!empty($post['lengthMUId'])) {
                $lengthMUId = $post['lengthMUId'];
            }
            $endDate = null;
            if (!empty($post['endDate'])) {
                $endDate = $post['endDate'];
            }

            $retval['changedId'] = isset($changedId) ? $changedId : '';
            $dbDateTimeFormat = 'Y-m-d';

            if (isset($changedId)) {
                switch ($changedId) {
                    case 'TaskLengthMeasurementUnit':
                        if (is_null($lengthMUId) || !is_numeric($lengthValue)) {
                            break;
                        }
                    case 'projectstasks-duration':
                    case 'projectstasks-start_date':
                        if (!is_null($lengthMUId) && is_numeric($lengthValue)) {
                            $doCalculate = true;
                            $interval = 'P';
                            switch ($lengthMUId) {
                                case 'hours':
                                    $interval .= 'T' . $lengthValue . 'H';
                                    if ($lengthValue < 24) {
                                        $doCalculate = false;
                                    }
                                    break;
                                case 'days':
                                    $interval .= 'T' . ($lengthValue * 24) . 'H';
                                    break;
                                case 'weeks':
                                    $interval .= 'T' . (($lengthValue * 24) * 7) . 'H';
                                    break;
                                case 'months':
                                    $interval .= $lengthValue . 'M';
                                    break;
                                case 'years':
                                    $interval .= $lengthValue . 'Y';
                                    break;
                                default:
                                    $interval .= 'T' . ($lengthValue * 24) . 'H';
                                    break;

                            }
                            if ($doCalculate) {
                                $dateTime = \DateTime::createFromFormat($dbDateTimeFormat, $beginDate);
                                $dateTime->add(new \DateInterval($interval));
                                $retValDateTime = $dateTime->format($dbDateTimeFormat);
                                $retval['endDatetime'] = $retValDateTime;
                                $retval['endDate'] = \Yii::$app->getFormatter()->asDate($retValDateTime, 'dd-MM-Y');
                            }
                        } else {
                            if (isset($endDate)) {
                                if ($beginDate == $endDate) {
                                    $retval['duration'] = 1;
                                    $retval['durationUnit'] = 'days';
                                } else {
                                    $beginDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $beginDate);
                                    $endDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $endDate);
                                    if ($beginDateTime->getTimestamp() < $endDateTime->getTimestamp()) {
                                        $duration = $endDateTime->diff($beginDateTime);
                                        $durationDays = $duration->days;
                                        $retval['duration'] = $durationDays;
                                        $retval['durationUnit'] = 'days';
                                    }
                                }
                            }
                        }
                        break;

                    case 'projectstasks-end_date':
//                        if (!is_null($lengthMUId) && is_numeric($lengthValue) && !empty($endDate)) {
//                            $doCalculate = true;
//                            $interval = 'P';
//                            switch ($lengthMUId) {
//                                case 'hours':
//                                    $interval .= 'T' . $lengthValue . 'H';
//                                    if ($lengthValue < 24) {
//                                        $doCalculate = false;
//                                    }
//                                    break;
//                                case 'days':
//                                    $interval .= 'T' . ($lengthValue * 24) . 'H';
//                                    break;
//                                case 'weeks':
//                                    $interval .= 'T' . (($lengthValue * 24) * 7) . 'H';
//                                    break;
//                                case 'months':
//                                    $interval .= $lengthValue . 'M';
//                                    break;
//                                case 'years':
//                                    $interval .= $lengthValue . 'Y';
//                                    break;
//                                default:
//                                    $interval .= 'T' . ($lengthValue * 24) . 'H';
//                                    break;
//
//                            }
//                            if ($doCalculate) {
//                                $dateTime = \DateTime::createFromFormat($dbDateTimeFormat, $endDate);
//                                $dateTime->sub(new \DateInterval($interval));
//                                $retValDateTime = $dateTime->format($dbDateTimeFormat);
//                                $retval['startDatetime'] = $retValDateTime;
//                                $retval['startDate'] = \Yii::$app->getFormatter()->asDate($retValDateTime, 'dd-MM-Y');
//                            }
//                        } else {
//                            if (isset($beginDate)) {
//                                if ($beginDate == $endDate) {
//                                    $retval['duration'] = 1;
//                                    $retval['durationUnit'] = 'days';
//                                } elseif (!empty($endDate)) {
//                                    $beginDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $beginDate);
//                                    $endDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $endDate);
////                                    pr($beginDateTime->getTimestamp(),$endDateTime->getTimestamp());
//                                    if ($beginDateTime->getTimestamp() < $endDateTime->getTimestamp()) {
//                                        $duration = $endDateTime->diff($beginDateTime);
//                                        $durationDays = $duration->days;
//                                        $retval['duration'] = $durationDays;
//                                        $retval['durationUnit'] = 'days';
//                                    }
//                                }
//                            }
//                        }

                        if (isset($beginDate)) {
                            if ($beginDate == $endDate) {
                                $retval['duration'] = 1;
                                $retval['durationUnit'] = 'days';
                            } elseif (!empty($endDate)) {
                                $beginDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $beginDate);
                                $endDateTime = \DateTime::createFromFormat($dbDateTimeFormat, $endDate);
                                $duration = $endDateTime->diff($beginDateTime);
                                $durationDays = $duration->days;
                                if ($beginDateTime->getTimestamp() > $endDateTime->getTimestamp()) {
                                    $durationDays = $durationDays * (-1);
                                }
                                $retval['duration'] = $durationDays;
                                $retval['durationUnit'] = 'days';
                            }
                        }
                        break;
                }
            }
            return json_encode($retval);
        }
        return json_encode($retval);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $postData = \Yii::$app->request->post();

        if (!$postData || !isset($postData['relationType'])) {
            $this->checkAndSendRelationErrors($model);
        }

        return parent::actionUpdate($id);
    }

    public function checkAndSendRelationErrors(ProjectsTasks $model)
    {
        /**
         * @var $requiredMm ProjectsTasksTasksMm
         */
        foreach ($model->projectsRequiredTasksMms as $requiredMm) {
            $requiredTask = $requiredMm->requiredTasks;
            $relationType = (int)$requiredMm->typeNumber;

            switch ($relationType) {
                case ProjectsTasksTasksMm::START_TO_START:
                    {
                        //model start date should be greater or equal to required task one (should not be less)
                        $requiredTask->startTime > $model->startTime ? self::throwRelationError($relationType,
                            $requiredTask) : false;
                    }
                    break;
                case ProjectsTasksTasksMm::FINISH_TO_FINISH:
                    {
                        //model end date should be greater or equal to required task one (should not be less)
                        $requiredTask->endTime > $model->endTime ? self::throwRelationError($relationType,
                            $requiredTask) : false;
                    }
                    break;
                case ProjectsTasksTasksMm::START_TO_FINISH:
                    {
                        //model end date should be greater or equal to required start date (should not be less)
                        $requiredTask->startTime > $model->endTime ? self::throwRelationError($relationType,
                            $requiredTask) : false;
                    }
                    break;
                case ProjectsTasksTasksMm::FINISH_TO_START:
                    {
                        //model start date should be greater or equal to required end date (should not be less)
                        $requiredTask->endTime > $model->startTime ? self::throwRelationError($relationType,
                            $requiredTask) : false;
                    }
                    break;
            }
        }

        return true;
    }

    /**
     * @param int $code
     * @param ProjectsTasks $requiredTask
     */
    public function throwRelationError($code, $requiredTask)
    {
        $message = self::getRelationError($code, $requiredTask);

        return \Yii::$app->session->addFlash('warning', $message);
    }

    /**
     * @param int $code
     * @param ProjectsTasks $requiredTask
     * @return string
     */
    public static function getRelationError($code, $requiredTask)
    {
        $message = '';

        if (!empty($requiredTask)) {
            switch ($code) {
                case ProjectsTasksTasksMm::F2F_MISMATCH:
                    $message = Module::t('amosproject_management', ProjectsTasksTasksMm::F2F_MISMATCH_MSG, ['task_title' => $requiredTask->name]);
                    break;
                case ProjectsTasksTasksMm::S2F_MISMATCH:
                    $message = Module::t('amosproject_management', ProjectsTasksTasksMm::S2F_MISMATCH_MSG, ['task_title' => $requiredTask->name]);
                    break;
                case ProjectsTasksTasksMm::S2S_MISMATCH:
                    $message = Module::t('amosproject_management', ProjectsTasksTasksMm::S2S_MISMATCH_MSG, ['task_title' => $requiredTask->name]);
                    break;
                // decided by F.F. not checked! - changed with POII-1060 and POII-1074
                case ProjectsTasksTasksMm::F2S_MISMATCH:
                    $message = Module::t('amosproject_management', ProjectsTasksTasksMm::F2S_MISMATCH_MSG, ['task_title' => $requiredTask->name]);
                    break;
            }
        }

        return $message;
    }

}
