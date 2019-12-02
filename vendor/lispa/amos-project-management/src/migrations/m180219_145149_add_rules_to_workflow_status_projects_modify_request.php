<?php

use yii\db\Migration;

/**
 * Class m180219_145149_add_rules_to_workflow_status_projects_modify_request
 */
class m180219_145149_add_rules_to_workflow_status_projects_modify_request  extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowClosedRule::className(),
                'description' => 'Rule permission ProjectsModifyRequestWorkflowClosedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowClosedRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => [\lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                ]
            ],

            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowValidatedRule::className(),
                'description' => 'Rule permission ProjectsModifyRequestWorkflowValidatedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowValidatedRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => [\lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                ]
            ],

            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowTovalidateRule::className(),
                'description' => 'Rule permission ProjectsModifyRequestWorkflowTovalidateRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowTovalidateRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => [\lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                ]
            ],

            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowRejectedRule::className(),
                'description' => 'Rule permission ProjectsModifyRequestWorkflowRejectedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowRejectedRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => [\lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                ]
            ],

            [
                'name' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowOneditRule::className(),
                'description' => 'Rule permission ProjectsModifyRequestWorkflowOneditRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => \lispa\amos\projectmanagement\rules\workflow\ProjectsModifyRequestWorkflowOneditRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => [\lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT],
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                ]
            ],

        ];
    }
}