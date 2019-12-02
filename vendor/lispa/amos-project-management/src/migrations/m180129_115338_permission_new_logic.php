<?php

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m180129_115338_permission_new_logic
 */
class m180129_115338_permission_new_logic extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\rules\ProjectsCreateRule::className(),
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permesso di cancellazione di una propria discussione',
                'ruleName' => \lispa\amos\projectmanagement\rules\ProjectsCreateRule::className(),
                'children' => ['PROJECTS_CREATE'],
                'parent' => ['PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTS_CREATE',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECT_MANAGER']
                ]
            ],
        ];
    }
}
