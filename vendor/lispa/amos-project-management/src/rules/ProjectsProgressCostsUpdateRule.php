<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules;

use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressCosts;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use yii\rbac\Rule;

class ProjectsProgressCostsUpdateRule extends Rule
{

    public $name = 'projectsProgressCostUpdate';

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {

        if (isset($params['model'])) {
            if ($params['model']->className() == ProjectsProgressCosts::className()
                || $params['model']->className() == \lispa\amos\projectmanagement\models\base\ProjectsProgressCosts::className()) {
                /** @var ProjectsProgressCosts $model */
                $model = $params['model'];
                if ($model->isNewRecord) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($post['id']);
                    }
                }

                if ($model->isNewRecord) return true;

                $project = $model->projectsProgressDetectionPeriod->projects;

                if (isset($params['checkDate'])) {
                    if ($params['checkDate']) {
                        if (!$this->checkDate($model)) {
                            return false;
                        }
                    }
                } else {
                    if (!$this->checkDate($model)) {
                        return false;
                    }
                }

                // The project in validated
                $can = ($project->status == Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED);
                // The logged user is responsible of activity or task
                $can &= $this->isLoggedUserResponsibleTaskOrActivity($model->projectsTask);
                // The status of detection perio id In Progress
                $can &= ($model->projectsProgressDetectionPeriod->status == ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS);
                // This progress statement is on edit
                $can &= ($model->status == ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT);

                if($can) {
                    return $can;
                }
                else {
                    //If the logged user is a PM and not a Responsible for a task/activity, he can only pass the status of the progress statement to CONFIRMED
                    if (ProjectManagementUtility::loggedUsedIsCommunityManager() && $model->status == ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED){
                        return true;
                    }
                    return false;
                }
            }
        }
        return false;
    }


    /**
     * @param $model
     * @return bool
     */
    private function checkDate($model) {
        //check if NOW is in detection period (start date - end date)
        $start = strtotime($model->projectsProgressDetectionPeriod->start_date);
        $end = strtotime($model->projectsProgressDetectionPeriod->end_date);
        $today = strtotime(date("Y-m-d"));
        if (($today < $start) || ($today > $end)) {
            return false;
        }
        return true;
    }

    /**
     * @param int $modelId
     * @return mixed
     */
    private function instanceModel($modelId)
    {
        $model = null;
        /** @var ProjectsProgressCosts $instance */
        $instancedModel = ProjectsProgressCosts::findOne($modelId);
        if (!is_null($instancedModel)) {
            $model = $instancedModel;
        }
        return $model;
    }

    /**
     * @param ProjectsTasks $task
     * @return bool
     */
    private function isLoggedUserResponsibleTaskOrActivity(ProjectsTasks $task)
    {
        if (\Yii::$app->user->id == $task->user_responsible_costs_id) {
            return true;
        }

        $activity = $task->projectsActivities;
//        pr($activity->getUserResponsibleId());
        if (\Yii::$app->user->id == $activity->getUserResponsibleId()) {
            return true;
        }

        return false;
    }

}