<?php

use yii\db\Migration;

/**
 * Class m180221_154839_create_table_activity_progress_detection
 */
class m180221_154839_create_table_activity_progress_detection extends Migration
{
    const TABLE_PPD_T = '{{%projects_progress_detection_type}}';
    const TABLE_PPD_P = '{{%projects_progress_detection_period}}';
    const TABLE_PPS_T = '{{%projects_progress_statements_type}}';
    const TABLE_PPS = '{{%projects_progress_statements}}';

    public function safeUp()
    {
        if ($this->db->schema->getTableSchema(self::TABLE_PPD_T, true) === null) {
            $this->createTable(self::TABLE_PPD_T, [
                'id' => $this->primaryKey(11),
                'name' => $this->string(255)->defaultValue(NULL)->comment('Name'),
                'description' => $this->text()->defaultValue(NULL)->comment('Description'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->insert(self::TABLE_PPD_T,['id' => 1, 'name' => 'Activity progress', 'created_at' => new \yii\db\Expression('NOW()')]);
            $this->insert(self::TABLE_PPD_T,['id' => 2, 'name' => 'Consumption costs', 'created_at' => new \yii\db\Expression('NOW()')]);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PPD_P, true) === null) {
            $this->createTable(self::TABLE_PPD_P, [
                'id' => $this->primaryKey(11),
                'status' => $this->string(255)->defaultValue(null)->comment('Status'),
                'warning_date' => $this->date()->defaultValue(null)->comment('Warning date'),
                'start_date' => $this->date()->defaultValue(null)->comment('Start date'),
                'end_date' => $this->date()->defaultValue(null)->comment('End date'),
                'projects_progress_detection_type_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_progress_detection_type'),
                'projects_id' => $this->integer(11)->defaultValue(null)->comment('FK to project'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->addForeignKey('fk_progress_detection_period_projects_01', self::TABLE_PPD_P, 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_progress_detection_period_type_01', self::TABLE_PPD_P, 'projects_progress_detection_type_id', 'projects_progress_detection_type', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PPS_T, true) === null) {
            $this->createTable(self::TABLE_PPS_T, [
                'id' => $this->primaryKey(11),
                'name' => $this->string(255)->defaultValue(NULL)->comment('Name'),
                'description' => $this->text()->defaultValue(NULL)->comment('Description'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->insert(self::TABLE_PPS_T,['id' => 1, 'name' => 'Regular', 'created_at' => new \yii\db\Expression('NOW()')]);
            $this->insert(self::TABLE_PPS_T,['id' => 2, 'name' => 'Recoverable delay', 'created_at' => new \yii\db\Expression('NOW()')]);
            $this->insert(self::TABLE_PPS_T,['id' => 3, 'name' => 'critic', 'created_at' => new \yii\db\Expression('NOW()')]);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PPS, true) === null) {
            $this->createTable(self::TABLE_PPS, [
                'id' =>$this->primaryKey(11),
                'status' => $this->string(255)->defaultValue(null)->comment('Status'),
                'note' => $this->text()->defaultValue(null)->comment('Note'),
                'last_confirmed_time' => $this->dateTime()->null()->defaultValue(null)->comment('Last confirmed time'),
                'projects_progress_statements_type_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_progress_statements_type'),
                'projects_progress_detection_period_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_progress_detection_period'),
                'projects_task_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_task'),
                'user_responsible_id' => $this->integer(11)->defaultValue(null)->comment('FK to user_id the responsible of task'),
                'organization_id' => $this->integer(11)->defaultValue(null)->comment('Organization responsible'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->addForeignKey('fk_statement_period_01', self::TABLE_PPS, 'projects_progress_detection_period_id', 'projects_progress_detection_period', 'id');
            $this->addForeignKey('fk_statements_type_01', self::TABLE_PPS, 'projects_progress_statements_type_id', 'projects_progress_statements_type', 'id');
            $this->addForeignKey('fk_statements_task_01', self::TABLE_PPS, 'projects_task_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_statements_user_01', self::TABLE_PPS, 'user_responsible_id', 'user', 'id');
        }

    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        if ($this->db->schema->getTableSchema(self::TABLE_PPD_T, true) !== null) {
            $this->dropTable(self::TABLE_PPD_T);
        }
        if ($this->db->schema->getTableSchema(self::TABLE_PPD_P, true) !== null) {
            $this->dropTable(self::TABLE_PPD_P);
        }
        if ($this->db->schema->getTableSchema(self::TABLE_PPS_T, true) !== null) {
            $this->dropTable(self::TABLE_PPS_T);
        }
        if ($this->db->schema->getTableSchema(self::TABLE_PPS, true) !== null) {
            $this->dropTable(self::TABLE_PPS);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}
