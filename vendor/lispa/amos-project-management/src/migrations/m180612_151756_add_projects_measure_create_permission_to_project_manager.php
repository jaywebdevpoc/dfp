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
use lispa\amos\projectmanagement\rules\ProjectsMeasureCreateRule;
use yii\rbac\Permission;

/**
 * Class m180612_151756_add_projects_measure_create_permission_to_project_manager
 */
class m180612_151756_add_projects_measure_create_permission_to_project_manager extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => ProjectsMeasureCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso con regola per creazione ProjectsMeasure',
                'ruleName' => ProjectsMeasureCreateRule::className(),
                'parent' => ['PM_BY_COMMUNITY_ROLE'],
                'children' => ['PROJECTSMEASURE_CREATE']
            ]
        ];
    }
}
