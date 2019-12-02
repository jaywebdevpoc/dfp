<?php

use yii\db\Migration;

/**
 * Class m180219_145149_add_rules_to_workflow_status_projects_modify_request
 */
class m180508_143249_add_rules_to_workflow_status_projects  extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsValidatedWorkflowRule::className(),
                'description' => 'Rule permission ProjectsValidatedWorkflowRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsValidatedWorkflowRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE'],
                    'addParents' => [\lispa\amos\projectmanagement\rules\workflow\ProjectsValidatedWorkflowRule::className()]
                ]
            ],
        ];
    }
}