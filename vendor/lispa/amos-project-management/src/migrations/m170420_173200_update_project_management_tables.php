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

class m170420_173200_update_project_management_tables extends Migration
{
    const MODULE_NAME = 'project_management';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $this->execute("ALTER TABLE `projects` ADD `status` varchar(255) NULL DEFAULT '0' AFTER `membership_type_id`;");
        $this->execute("ALTER TABLE `projects` ADD `version` int(11) NULL DEFAULT '0' AFTER `deleted_by`;");

        $this->execute("ALTER TABLE `projects_tasks` ADD `status` varchar(255) NULL DEFAULT '0' AFTER `publish`;");
        $this->execute("ALTER TABLE `projects_tasks` ADD `version` int(11) NULL DEFAULT '0' AFTER `deleted_by`;");

        $this->execute("ALTER TABLE `projects_activities` ADD `status` varchar(255) NULL DEFAULT '0' AFTER `publish`;");
        $this->execute("ALTER TABLE `projects_activities` ADD `version` int(11) NULL DEFAULT '0' AFTER `deleted_by`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $this->execute("ALTER TABLE `projects` DROP `status`;");
        $this->execute("ALTER TABLE `projects` DROP `version`;");

        $this->execute("ALTER TABLE `projects_tasks` DROP `status`;");
        $this->execute("ALTER TABLE `projects_tasks` DROP `version`;");

        $this->execute("ALTER TABLE `projects_activities` DROP `status`;");
        $this->execute("ALTER TABLE `projects_activities` DROP `version`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }
}
