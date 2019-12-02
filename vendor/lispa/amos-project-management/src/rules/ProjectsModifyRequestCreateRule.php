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

use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use yii\rbac\Rule;
use Yii;
use lispa\amos\projectmanagement\models\Projects;

class ProjectsModifyRequestCreateRule extends Rule
{

    public $name = 'projectsModifyRequestCreate';
    private $statusEnabled = [
        Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT,
        Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
    ];

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
        $project = null;
        // FIND project to define if the user is one of the responsibles
        if (isset($params['model'])) {
            $model = $params['model'];
            if ($model instanceof Projects) {
                $project = $model;
            } elseif ($model instanceof ProjectsModifyRequest && !empty($model->projects_id)) {
                /** @var ProjectsModifyRequest $modifyRequest */
                $modifyRequest = $params['model'];
                $project = $modifyRequest->projects;
            }
        } else {
            $projectId = Yii::$app->request->get('pid');
            $project = Projects::findOne($projectId);
        }

        // first rule, the project is only one per community
        if (!empty($project)) {
//            $responsiblesIds = $project->getProjectAllResponsiblesUsersWorkPaln();
            if (in_array($project->status, $this->statusEnabled)) {
                $responsiblesIds = $project->getActivitiesReferentUserIds();
                return in_array(Yii::$app->user->id, $responsiblesIds);
            }
        }

        return false;
    }

}