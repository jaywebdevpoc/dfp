<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m180911_081424_new_compila_sondaggi_widgets_permissions
 */
class m190118_092124_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        $prefixStr = 'Permissions for the dashboard for the widget ';
        return [
            [
                'name' => 'SondaggiValidate',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['VALIDATED_BASIC_USER'],
                    'addParents' => ['COMPILATORE_SONDAGGI',]
                ]
            ],
        ];
    }
}
