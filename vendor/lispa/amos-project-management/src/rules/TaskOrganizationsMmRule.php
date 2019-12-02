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

use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksCosts;
use yii\helpers\VarDumper;
use yii\rbac\Item;
use yii\rbac\Rule;

class TaskOrganizationsMmRule extends Rule
{

    public $name = 'taskOrganizationsMm';

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['action']) && $params['action'] == M2MWidget::ACTION_DELETE) {
            if (isset($params['targetId']) && is_integer($params['targetId']) && isset($params['id']) && is_integer($params['id'])) {
                $orgId = $params['targetId'];
                $taskId = $params['id'];
                /** @var ProjectsTasks $task */
                $task = ProjectsTasks::findOne($taskId);
                $canDelete = true;

                //check if cost of this organization is empty
                $listOfCosts = ProjectsTasksCosts::find()->andWhere([
                    'projects_tasks_id' => $taskId,
                    'organization_id' => $orgId,
                ])->all();

                /** @var ProjectsTasksCosts $ptc */
                foreach ($listOfCosts as $ptc) {
                    if ($ptc->value > 0) {
                        $canDelete = false;
                    }
                }

                // check if the organization is responsible of this task
                if ($canDelete && ($task->getOrganizationResponsibleId() == $orgId)) {
                    $canDelete = false;
                }

                return $canDelete;
            }
        }

        // This rule is used for delete and create relation
        return true;
    }
}