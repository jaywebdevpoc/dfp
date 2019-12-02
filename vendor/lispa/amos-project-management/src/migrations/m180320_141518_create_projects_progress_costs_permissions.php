<?php

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;
use lispa\amos\projectmanagement\rules\ProjectsProgressCostsCreateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressCostsUpdateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressCostsReadRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressCostsDeleteRule;

class m180320_141518_create_projects_progress_costs_permissions extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {

        return [

            [
                'name' => 'PROJECTSPROGRESSCOSTS_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Role manager progress costs',
                'parent' => ['PROJECT_MANAGER']
            ],

            [
                'name' => ProjectsProgressCostsCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on create projectsProgressCosts',
                'ruleName' => ProjectsProgressCostsCreateRule::className(),
                'parent' => ['PROJECTSPROGRESSCOSTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSCOSTS_CREATE']
            ],

            [
                'name' => ProjectsProgressCostsUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on update projectsProgressCosts',
                'ruleName' => ProjectsProgressCostsUpdateRule::className(),
                'parent' => ['PROJECTSPROGRESSCOSTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSCOSTS_UPDATE']
            ],

            [
                'name' => ProjectsProgressCostsReadRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on read projectsProgressCosts',
                'ruleName' => ProjectsProgressCostsReadRule::className(),
                'parent' => ['PROJECTSPROGRESSCOSTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSCOSTS_READ']
            ],

            [
                'name' => ProjectsProgressCostsDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on read projectsProgressCosts',
                'ruleName' => ProjectsProgressCostsDeleteRule::className(),
                'parent' => ['PROJECTSPROGRESSCOSTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSCOSTS_DELETE']
            ],

            [
                'name' => 'PROJECTSPROGRESSCOSTS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model ',
            ],
            [
                'name' => 'PROJECTSPROGRESSCOSTS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model ProjectsProgressCosts',
            ],
            [
                'name' => 'PROJECTSPROGRESSCOSTS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model ProjectsProgressCosts',
            ],
            [
                'name' => 'PROJECTSPROGRESSCOSTS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model ProjectsProgressCosts',
            ],

        ];
    }
}