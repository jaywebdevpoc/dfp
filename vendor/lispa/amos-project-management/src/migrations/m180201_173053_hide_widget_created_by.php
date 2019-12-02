<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use yii\db\Schema;

/**
 * Default migration for the `project_management` plugin
 */
class m180201_173053_hide_widget_created_by extends \yii\db\Migration
{

    public function safeUp()
    {
        $this->update('amos_widgets', ['status' => 0], ['classname' => 'lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects']);

    }

    public function safeDown()
    {
        $this->update('amos_widgets', ['status' => 1], ['classname' => 'lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects']);
    }
}