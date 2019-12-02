<?php

use lispa\amos\dashboard\models\AmosWidgets;
use lispa\amos\core\migration\AmosMigrationWidgets;

class m180313_154404_widget_own_projects extends AmosMigrationWidgets
{
    const MODULE_NAME = 'project_management';

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconOwnProjects::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'dashboard_visible' => 1
            ],
        ];
    }
}
