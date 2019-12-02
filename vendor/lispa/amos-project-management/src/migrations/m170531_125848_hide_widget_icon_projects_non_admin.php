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
 * Class m170531_125848_hide_widget_icon_projects_non_admin
 */
class m170531_125848_hide_widget_icon_projects_non_admin extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconprojects::className(),
                'update' => true,
                'newValues' => [
                    'addParents' => ['ADMIN'],
                    'removeParents' => ['PARTNER_REFERENT'],
                ]
            ]
        ];
    }
}
