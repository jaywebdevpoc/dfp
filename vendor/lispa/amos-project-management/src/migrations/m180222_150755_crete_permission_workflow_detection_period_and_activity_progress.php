<?php

use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\rules\workflow\ProjectsDetectionPeriodWorkflowClosedRule;
use lispa\amos\projectmanagement\rules\workflow\ProjectsDetectionPeriodWorkflowInprogressRule;
use lispa\amos\projectmanagement\rules\workflow\ProjectsDetectionPeriodWorkflowPlannedRule;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;
use lispa\amos\projectmanagement\rules\workflow\ProjectsActivityProgressWorkflowConfirmedRule;
use lispa\amos\projectmanagement\rules\workflow\ProjectsActivityProgressWorkflowOneditRule;

/**
 * Class m180222_150755_crete_permission_workflow_detection_period_and_activity_progress
 */
class m180222_150755_crete_permission_workflow_detection_period_and_activity_progress extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => ProjectsDetectionPeriodWorkflowClosedRule::className(),
                'description' => 'Rule permission ProjectsDetectionPeriodWorkflowClosedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => ProjectsDetectionPeriodWorkflowClosedRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => [ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED],
            ],

            [
                'name' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED,
                'description' => 'Permission ' . ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
            ],

            [
                'name' => ProjectsDetectionPeriodWorkflowInprogressRule::className(),
                'description' => 'Rule permission ProjectsDetectionPeriodWorkflowInprogressRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => ProjectsDetectionPeriodWorkflowInprogressRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => [ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS],
            ],

            [
                'name' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS,
                'description' => 'Permission ' . ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
            ],

            [
                'name' => ProjectsDetectionPeriodWorkflowPlannedRule::className(),
                'description' => 'Rule permission ProjectsDetectionPeriodWorkflowPlannedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => ProjectsDetectionPeriodWorkflowPlannedRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => [ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED],
            ],

            [
                'name' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED,
                'description' => 'Permission ' . ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
            ],

            [
                'name' => ProjectsActivityProgressWorkflowConfirmedRule::className(),
                'description' => 'Rule permission ProjectsActivityProgressWorkflowConfirmedRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => ProjectsActivityProgressWorkflowConfirmedRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => [ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED],
            ],

            [
                'name' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED,
                'description' => 'Permission ' . ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
            ],

            [
                'name' => ProjectsActivityProgressWorkflowOneditRule::className(),
                'description' => 'Rule permission ProjectsActivityProgressWorkflowOneditRule',
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'ruleName' => ProjectsActivityProgressWorkflowOneditRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => [ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT],
            ],

            [
                'name' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT,
                'description' => 'Permission ' . ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
            ],

        ];
    }
}