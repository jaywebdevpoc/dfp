<?php

use yii\db\Migration;

class m180313_154721_permission_widget_own_projects extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconOwnProjects::className(),
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permission to widget all own projects',
                'parent' => ['PARTNER_REFERENT']
            ],
        ];
    }
}
