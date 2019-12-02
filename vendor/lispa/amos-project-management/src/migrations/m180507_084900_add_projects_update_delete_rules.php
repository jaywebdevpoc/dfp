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
use lispa\amos\projectmanagement\rules\ProjectsDeleteRule;
use lispa\amos\projectmanagement\rules\ProjectsUpdateRule;
use yii\rbac\Permission;

/**
 * Class m180507_084900_add_projects_update_delete_rules
 */
class m180507_084900_add_projects_update_delete_rules extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => ProjectsUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di update sul model Projects',
                'ruleName' => ProjectsUpdateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTS_UPDATE']
            ],
            [
                'name' => ProjectsDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Regola per permesso di delete sul model Projects',
                'ruleName' => ProjectsDeleteRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTS_DELETE']
            ],
            [
                'name' => 'PROJECTS_UPDATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTS_DELETE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ]
        ];
    }
}
