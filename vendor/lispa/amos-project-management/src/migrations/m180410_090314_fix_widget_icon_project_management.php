<?php

use yii\db\Migration;

class m180410_090314_fix_widget_icon_project_management extends Migration
{
    public function safeUp()
    {
        $this->update('amos_widgets', [
            'module' => 'community',
            'child_of' => 'lispa\\amos\\community\\widgets\\icons\\WidgetIconCommunityDashboard',
            'dashboard_visible' => 0,
            'default_order' => 1,
            'sub_dashboard' => 1,
        ], ['classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()]);

    }

    public function safeDown()
    {
       // DO NOTHING
    }
}
