<?php

use yii\rbac\Permission;
use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;

/**
 * Class m180215_115947_permission_projects_wf_status
 */
class m180216_115947_permission_projects_modify_request_wf_status extends AmosMigrationPermissions
{
    protected function setAuthorizations()
    {
        $this->authorizations = [
            [
                'name' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT,
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
            ],
            [
                'name' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE,
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
            ],
            [
                'name' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED,
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
            ],
            [
                'name' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED,
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
            ],
            [
                'name' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED,
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission ' . ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED,
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
            ],
        ];
    }
}