<?php

use yii\rbac\Permission;
use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\projectmanagement\models\Projects;

/**
 * Class m180215_115947_permission_projects_wf_status
 */
class m180215_115947_permission_projects_wf_status extends AmosMigrationPermissions
{
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => Projects::PROJECTS_WORKFLOW_STATUS_STARTUP,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . Projects::PROJECTS_WORKFLOW_STATUS_STARTUP,
                'ruleName' => null,
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
            ],
            [
                'name' => Projects::PROJECTS_WORKFLOW_STATUS_CLOSED,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . Projects::PROJECTS_WORKFLOW_STATUS_CLOSED,
                'ruleName' => null,
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
            ],
            [
                'name' => Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT,
                'ruleName' => null,
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
            ],
            [
                'name' => Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
                'ruleName' => null,
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
            ],
        ];
    }
}