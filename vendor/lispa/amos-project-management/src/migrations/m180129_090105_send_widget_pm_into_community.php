<?php

use yii\db\Migration;

/**
 * Class m180129_090105_send_widget_pm_into_community
 */
class m180129_090105_send_widget_pm_into_community extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->update('amos_widgets',[
            'dashboard_visible' => 0
        ],
            [
            'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->update('amos_widgets',[
            'dashboard_visible' => 1
        ], [
            'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()
        ]);
    }

}
