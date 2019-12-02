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

/**
 * Class m180508_071944_projects_measure_permissions_only_to_admin
 */
class m180508_071944_projects_measure_permissions_only_to_admin extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'PROJECTSMEASURE_CREATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSMEASURE_UPDATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE']
                ]
            ],
            [
                'name' => 'PROJECTSMEASURE_DELETE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PM_BY_COMMUNITY_ROLE', 'PROJECT_MANAGER']
                ]
            ]
        ];
    }
}
