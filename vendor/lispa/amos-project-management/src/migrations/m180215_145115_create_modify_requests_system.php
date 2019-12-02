<?php

use yii\db\Migration;

/**
 * Class m180215_145115_create_modify_requests_system
 */
class m180215_145115_create_modify_requests_system extends Migration
{
    const TABLE_MR = '{{%projects_modify_request}}';
    const TABLE_AT_MR_MM = '{{%projects_at_modify_request_mm}}';

    public function safeUp()
    {

        if ($this->db->schema->getTableSchema(self::TABLE_MR, true) === null) {

            $this->createTable(self::TABLE_MR, [
                'id' =>$this->primaryKey(11),
                'status' =>$this->string(255)->defaultValue(null)->comment('Status'),
                'description' => $this->text()->defaultValue(null)->comment('Description'),
                'projects_id' => $this->integer(11)->defaultValue(null)->comment('FK to project'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->addForeignKey('fk_modify_request_projects_01', self::TABLE_MR, 'projects_id', 'projects', 'id');

        }

        if ($this->db->schema->getTableSchema(self::TABLE_AT_MR_MM, true) === null) {

            $this->createTable(self::TABLE_AT_MR_MM, [
                'id' =>$this->primaryKey(11),
                'projects_activities_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_activities'),
                'projects_tasks_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_tasks'),
                'projects_modify_request_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_modify_request'),
                'created_at' => $this->dateTime()->null()->defaultValue(null),
                'updated_at' => $this->dateTime()->null()->defaultValue(null),
                'deleted_at' => $this->dateTime()->null()->defaultValue(null),
                'created_by' => $this->integer()->null()->defaultValue(null),
                'updated_by' => $this->integer()->null()->defaultValue(null),
                'deleted_by' => $this->integer()->null()->defaultValue(null),
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);

            $this->addForeignKey('fk_mm_projects_activities_01', self::TABLE_AT_MR_MM, 'projects_activities_id', 'projects_activities', 'id');
            $this->addForeignKey('fk_mm_projects_tasks_01', self::TABLE_AT_MR_MM, 'projects_tasks_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_mm_projects_modify_request_01', self::TABLE_AT_MR_MM, 'projects_modify_request_id', 'projects_modify_request', 'id');

        }

    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        if ($this->db->schema->getTableSchema(self::TABLE_MR, true) !== null) {
            $this->dropTable(self::TABLE_MR);
        }
        if ($this->db->schema->getTableSchema(self::TABLE_AT_MR_MM, true) !== null) {
            $this->dropTable(self::TABLE_AT_MR_MM);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}
