<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;

/**
 * Class m171121_141418_change_widget_project_management_dashboard_visible
 */
class m171121_141418_change_widget_project_management_dashboard_visible extends AmosMigrationWidgets
{
    const MODULE_NAME = 'chat';
    
    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className(),
                'dashboard_visible' => 1,
                'update' => true
            ]
        ];
    }
}
