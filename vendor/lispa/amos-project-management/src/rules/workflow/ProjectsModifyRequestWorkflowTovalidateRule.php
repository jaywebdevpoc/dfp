<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules\workflow
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules\workflow;

use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use Yii;

/**
 * Class ProjectsModifyRequestWorkflowTovalidateRule
 * @package lispa\amos\projectmanagement\rules\workflow
 */
class ProjectsModifyRequestWorkflowTovalidateRule extends BasicContentRule
{
    public $name = 'projectsModifyRequestWorkflowTovalidate';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        /** @var Projects $project */
        if(!empty($model) && $model->className() == ProjectsModifyRequest::className()) {
            /** @var Projects $project */
            $project = $model->projects;
        }
        else {
            $project = $model;
        }
        if (ProjectManagementUtility::loggedUsedIsCommunityManager($project->communityId)) {
            return false;
        }
        // first rule, the project is only one per community
        if (!empty($project)) {
            $responsiblesIds = $project->getProjectAllResponsiblesUsersWorkPaln();
            $statusEnabled = [
                Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT,
                Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
            ];
            if (in_array($project->status, $statusEnabled)) {
                return in_array(Yii::$app->user->id, $responsiblesIds);
            }
        }
        return false;
    }
}
