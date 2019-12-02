<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\community\rules\UpdateOwnWorkgroupsRule;
use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m170512_084425_add_project_management_community_workflow_states
 */
class m170512_084425_add_project_management_community_workflow_states extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => UpdateOwnWorkgroupsRule::className(),
                'update' => true,
                'newValues' => [
                    'addParents' => ['PROJECT_MANAGER']
                ]
            ]
        ];
    }
}
