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
class m170323_093753_init_module_project_management extends \yii\db\Migration
{
    const TABLE_PROJECTS = '{{%projects}}';
    const TABLE_PROJECTS_STATES = '{{%projects_states}}';
    const TABLE_PROJECTS_MEASURE = '{{%projects_measure}}';
    const TABLE_PROJECTS_ACTIVITIES = '{{%projects_activities}}';
    const TABLE_PROJECTS_TASKS = '{{%projects_tasks}}';
    const TABLE_TASKS = '{{%projects_tasks}}';
    const TABLE_PROJECTS_TASK_STATUSES = '{{%projects_task_statuses}}';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");


        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS, true) === null) {

            $this->createTable(self::TABLE_PROJECTS, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'summary' => Schema::TYPE_STRING . "(255) NULL COMMENT 'Summary'",
                'insights' => Schema::TYPE_TEXT . "  NULL COMMENT 'Insights'",
                'start_date' => Schema::TYPE_DATE . "  NULL COMMENT 'Start Date'",
                'finish_date' => Schema::TYPE_DATE . "  NULL COMMENT 'Finish Date'",
                'website' => Schema::TYPE_STRING . "(255) NULL COMMENT 'Website'",
                'community_id' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Community'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_STATES, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_STATES, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_MEASURE, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_MEASURE, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'description' => Schema::TYPE_TEXT . "  NULL COMMENT 'Description'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ACTIVITIES, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_ACTIVITIES, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'description' => Schema::TYPE_TEXT . "  NULL COMMENT 'Description'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_TASKS, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'description' => Schema::TYPE_TEXT . "  NULL COMMENT 'Description'",
                'start_date' => Schema::TYPE_DATE . "  NULL COMMENT 'Start Date'",
                'duration' => Schema::TYPE_DECIMAL . "  NULL COMMENT 'Duration'",
                'duration_scale' => "enum('minutes','hours','days','monts','years') COLLATE utf8_unicode_ci DEFAULT 'minutes'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_TASKS, true) === null) {

            $this->createTable(self::TABLE_TASKS, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASK_STATUSES, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_TASK_STATUSES, [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING . "(255) NOT NULL COMMENT 'Name'",
                'description' => Schema::TYPE_TEXT . "  NULL COMMENT 'Description'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_STATES, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_STATES);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_MEASURE, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_MEASURE);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ACTIVITIES, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_ACTIVITIES);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASKS);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_TASKS, true) !== null) {
            $this->dropTable(self::TABLE_TASKS);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASK_STATUSES, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASK_STATUSES);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}