<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq\migrations
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use open20\amos\core\migration\AmosMigrationWidgets;

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
                'classname' => \open20\amos\faq\widgets\icons\WidgetIconFaqDashboard::className(),
                'dashboard_visible' => 1,
                'update' => true
            ]
        ];
    }
}
