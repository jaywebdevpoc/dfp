<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\projectmanagement\rules\ProjectsActivitiesCreateRule;
use lispa\amos\projectmanagement\rules\ProjectsActivitiesDeleteRule;
use lispa\amos\projectmanagement\rules\ProjectsActivitiesUpdateRule;
use lispa\amos\projectmanagement\rules\ProjectsTasksCreateRule;
use lispa\amos\projectmanagement\rules\ProjectsTasksDeleteRule;
use lispa\amos\projectmanagement\rules\ProjectsTasksUpdateRule;
use yii\rbac\Permission;

/**
 * Class m180508_075850_add_projects_activities_and_tasks_create_update_delete_rules
 */
class m180508_075850_add_projects_activities_and_tasks_create_update_delete_rules extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [

            // ProjectsActivities rules
            [
                'name' => ProjectsActivitiesCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di create sul model ProjectsActivities',
                'ruleName' => ProjectsActivitiesCreateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSACTIVITIES_CREATE']
            ],
            [
                'name' => ProjectsActivitiesUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di update sul model ProjectsActivities',
                'ruleName' => ProjectsActivitiesUpdateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSACTIVITIES_UPDATE']
            ],
            [
                'name' => ProjectsActivitiesDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di delete sul model ProjectsActivities',
                'ruleName' => ProjectsActivitiesDeleteRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSACTIVITIES_DELETE']
            ],
            [
                'name' => 'PROJECTSACTIVITIES_CREATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSACTIVITIES_UPDATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSACTIVITIES_DELETE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],

            // ProjectsTasks rules
            [
                'name' => ProjectsTasksCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di create sul model ProjectsTasks',
                'ruleName' => ProjectsTasksCreateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSTASKS_CREATE']
            ],
            [
                'name' => ProjectsTasksUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di update sul model ProjectsTasks',
                'ruleName' => ProjectsTasksUpdateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSTASKS_UPDATE']
            ],
            [
                'name' => ProjectsTasksDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di delete sul model ProjectsTasks',
                'ruleName' => ProjectsTasksDeleteRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSTASKS_DELETE']
            ],
            [
                'name' => 'PROJECTSTASKS_CREATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSTASKS_UPDATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSTASKS_DELETE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
        ];
    }
}
