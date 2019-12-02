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

class m170412_160700_update_project_management_tables extends Migration
{
    const MODULE_NAME = 'project_management';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $this->execute("ALTER TABLE `projects` ADD `membership_type_id` int(1) NULL DEFAULT '0' AFTER `community_id`;");
        $this->execute("ALTER TABLE `projects_activities` ADD `publish` int(1) NULL DEFAULT '0' AFTER `description`;");
        $this->execute("ALTER TABLE `projects_tasks` ADD `publish` int(1) NULL DEFAULT '0' AFTER `duration_scale`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $this->execute("ALTER TABLE `projects` DROP `membership_type_id`;");
        $this->execute("ALTER TABLE `projects_activities` DROP `publish`;");
        $this->execute("ALTER TABLE `projects_tasks` DROP `publish`;");
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");

        return true;
    }
}
