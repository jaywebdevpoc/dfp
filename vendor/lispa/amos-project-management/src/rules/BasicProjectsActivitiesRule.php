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
use yii\rbac\Rule;

/**
 * Class BasicProjectsActivitiesRule
 * @package lispa\amos\projectmanagement\rules
 */
abstract class BasicProjectsActivitiesRule extends Rule
{
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var ProjectsActivities $model */
            $model = $params['model'];
            $project = $this->instanceProjectsActivitiesProject($model);
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
     * @param ProjectsActivities $model
     * @return Projects|null
     */
    public function instanceProjectsActivitiesProject($model)
    {
        /** @var Projects $project */
        $project = null;
        if(!empty($model) && !$model->isNewRecord && $model instanceof Projects){
            return $model;
        }
        if (!is_null($model) && !is_null($model->projects)) {
            $project = $model->projects;
        }
        if (!$project) {
            $post = \Yii::$app->getRequest()->post();
            $get = \Yii::$app->getRequest()->get();
            if (isset($get['id'])) {
                $projectActivity = ProjectsActivities::findOne($get['id']);
                $project = (!is_null($projectActivity) ? $projectActivity->projects : null);
            } elseif (isset($post['id'])) {
                $projectActivity = ProjectsActivities::findOne($post['id']);
                $project = (!is_null($projectActivity) ? $projectActivity->projects : null);
            } elseif (isset($get['pid'])) {
                $project = Projects::findOne($get['pid']);
            } elseif (isset($post['pid'])) {
                $project = Projects::findOne($post['pid']);
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
