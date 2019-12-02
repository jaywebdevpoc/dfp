<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\utility\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;
use lispa\amos\dashboard\widgets\icons\WidgetIconManagement;
use lispa\amos\utility\widgets\icons\WidgetIconUtility;

/**
 * Class m191127_102711_init_utility_widget
 */
class m191127_102711_init_utility_widget extends AmosMigrationWidgets
{
    const MODULE_NAME = 'utility';

    /**
     * {@inheritdoc}
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => WidgetIconUtility::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => WidgetIconManagement::className(),
                'dashboard_visible' => 1,
                'default_order' => 100
            ]
        ];
    }
}
