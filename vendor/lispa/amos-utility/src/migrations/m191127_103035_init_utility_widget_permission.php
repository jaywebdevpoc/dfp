<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\utility\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\utility\widgets\icons\WidgetIconUtility;
use yii\rbac\Permission;

/**
 * Class m191127_103035_init_utility_widget_permission
 */
class m191127_103035_init_utility_widget_permission extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => WidgetIconUtility::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permissions for the dashboard for the widget WidgetIconUtility',
                'parent' => ['ADMIN']
            ]
        ];
    }
}
