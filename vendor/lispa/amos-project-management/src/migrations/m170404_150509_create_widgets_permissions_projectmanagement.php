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
use yii\rbac\Permission;

/**
 * Class m170404_150509_create_widgets_permissions_projectmanagement
 */
class m170404_150509_create_widgets_permissions_projectmanagement extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setAuthorizations()
    {
        $prefixStr = 'Permissions for the dashboard for the widget ';
        $this->authorizations = [
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconProjectManagement',
                'ruleName' => null,
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconprojects::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconprojects',
                'ruleName' => null,
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconMyProjects::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconMyProjects',
                'ruleName' => null,
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => $prefixStr . 'WidgetIconCreatedByProjects',
                'ruleName' => null,
                'parent' => ['PARTNER_REFERENT']
            ]
        ];
    }
}
