<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq\migrations
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\migration\AmosMigrationWidgets;

/**
 * Class m171011_093451_change_widget_faq_dashboard_visible
 */
class m171011_093451_change_widget_faq_dashboard_visible extends AmosMigrationWidgets
{
    const MODULE_NAME = 'faq';
    
    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\faq\widgets\icons\WidgetIconFaqDashboard::className(),
                'dashboard_visible' => 1,
                'update' => true
            ]
        ];
    }
}
