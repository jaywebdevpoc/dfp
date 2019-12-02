<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;

/**
 * Class m190204_114904_deactivate_WidgetIconCompilaSondaggi
 */
class m190204_114904_deactivate_WidgetIconCompilaSondaggi extends AmosMigrationWidgets
{
    const MODULE_NAME = 'sondaggi';

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\sondaggi\widgets\icons\WidgetIconCompilaSondaggi::className(),
                'update' => true,
                'status' => AmosWidgets::STATUS_DISABLED,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\sondaggi\widgets\icons\WidgetIconCompilaSondaggi::className(),
                'update' => true,
                'status' => AmosWidgets::STATUS_ENABLED,
            ]
        ];
        foreach ($this->widgets as $widgetData) {
            $ok = $this->insertOrUpdateWidget($widgetData);
            if (!$ok) {
                $allOk = false;
            }
        }
        return $allOk;
    }
}
