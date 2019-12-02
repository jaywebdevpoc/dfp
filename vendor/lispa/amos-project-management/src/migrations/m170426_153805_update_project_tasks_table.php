<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use yii\db\Migration;

class m170426_153805_update_project_tasks_table extends Migration
{
    const MODULE_NAME = 'project_management';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $table = Yii::$app->db->schema->getTableSchema('projects_tasks');
        if (!isset($table->columns['end_date'])) {
            $this->execute("ALTER TABLE `projects_tasks` ADD `end_date` date NULL COMMENT 'End Date' AFTER `start_date`;");
        }
        $this->execute("ALTER TABLE `projects_tasks` CHANGE `duration_scale` `duration_scale` enum('minutes','hours','days','weeks','months','years') COLLATE 'utf8_unicode_ci' NULL DEFAULT 'minutes' AFTER `duration`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $table = Yii::$app->db->schema->getTableSchema('projects_tasks');
        if (isset($table->columns['end_date'])) {
            $this->execute("ALTER TABLE `projects_tasks` DROP `end_date`;");
        }
        $this->execute("ALTER TABLE `projects_tasks` CHANGE `duration_scale` `duration_scale` enum('minutes','hours','days','months','years') COLLATE 'utf8_unicode_ci' NULL DEFAULT 'minutes' AFTER `duration`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }
}
