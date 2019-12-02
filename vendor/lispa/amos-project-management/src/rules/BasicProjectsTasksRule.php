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
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use yii\rbac\Rule;

/**
 * Class BasicProjectsTasksRule
 * @package lispa\amos\projectmanagement\rules
 */
abstract class BasicProjectsTasksRule extends Rule
{
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var ProjectsTasks $model */
            $model = $params['model'];
            $project = $this->instanceProjectsActivitiesTasks($model);
            if (is_null($project)) {
                return false;
            }
            $statusOk = $this->checkProjectStatus($project);
            return $statusOk;
        } else {
            return false;
        }
    }

    /**
     * @param ProjectsTasks $model
     * @return Projects|null
     */
    public function instanceProjectsActivitiesTasks($model)
    {
        /** @var Projects $project */
        $project = null;
        if (!is_null($model)) {
            if (($model instanceof Projects) && $model->id) {
                $project = $model;
            } elseif (($model instanceof ProjectsTasks) && !is_null($model->projectsActivities) && !is_null($model->projectsActivities->projects)) {
                $project = $model->projectsActivities->projects;
            }
        }
        if (!$project) {
            $post = \Yii::$app->getRequest()->post();
            $get = \Yii::$app->getRequest()->get();
            if (isset($get['id'])) {
                $projectTask = ProjectsTasks::findOne($get['id']);
                $project = (!is_null($projectTask) && !empty($projectTask->projectsActivities->projects) ? $projectTask->projectsActivities->projects : null);
            } elseif (isset($post['id'])) {
                $projectTask = ProjectsTasks::findOne($post['id']);
                $project = (!is_null($projectTask) && !empty($projectTask->projectsActivities->projects) ? $projectTask->projectsActivities->projects : null);
            } elseif (isset($get['activity_id'])) {
                $projectActivity = ProjectsActivities::findOne($get['activity_id']);
                $project = (!is_null($projectActivity) ? $projectActivity->projects : null);
            } elseif (isset($post['activity_id'])) {
                $projectActivity = ProjectsActivities::findOne($post['activity_id']);
                $project = (!is_null($projectActivity) ? $projectActivity->projects : null);
            }
        }
        return $project;
    }

    /**
     * @param Projects $model
     * @return bool
     */
    public function checkProjectStatus($model)
    {
        $allowedStatuses = [
            Projects::PROJECTS_WORKFLOW_STATUS_STARTUP,
            Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT
        ];
        return (in_array($model->status, $allowedStatuses));
    }
}
