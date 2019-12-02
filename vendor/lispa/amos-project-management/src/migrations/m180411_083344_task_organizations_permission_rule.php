<?php

use \lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;
use lispa\amos\projectmanagement\rules\TaskOrganizationsMmRule;

class m180411_083344_task_organizations_permission_rule extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {

        return [

            [
                'name' => TaskOrganizationsMmRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on create projectsProgressStatements',
                'ruleName' => TaskOrganizationsMmRule::className(),
                'parent' => ['PROJECT_MANAGER'],
                //'children' => ['PROJECTSPROGRESSSTATEMENTS_CREATE']
            ],

        ];
    }
}
