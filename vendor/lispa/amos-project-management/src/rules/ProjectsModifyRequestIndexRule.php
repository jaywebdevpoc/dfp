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

use lispa\amos\core\record\Record;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use yii\rbac\Rule;
use lispa\amos\cwh\AmosCwh;
use Yii;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\community\AmosCommunity;

class ProjectsModifyRequestIndexRule extends Rule
{

    public $name = 'projectsModifyRequestIndex';

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
        if (isset($params['model']) && $params['model'] instanceof ProjectsModifyRequest && !empty($params['model']->projects_id)) {
            /** @var ProjectsModifyRequest $modifyRequest */
            $modifyRequest = $params['model'];
            $project = $modifyRequest->projects;
        } else {
            $projectId = Yii::$app->request->get('pid');
            $project = Projects::findOne($projectId);
        }
        if (!empty($project)) {
            $responsiblesIds = $project->getProjectAllResponsiblesUsersWorkPaln();
            if ($project->status != Projects::PROJECTS_WORKFLOW_STATUS_STARTUP) {
                return in_array(Yii::$app->user->id, $responsiblesIds);
            }
        }
        return false;
    }

}