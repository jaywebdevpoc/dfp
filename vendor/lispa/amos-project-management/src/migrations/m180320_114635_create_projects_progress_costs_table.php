<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projects_progress_costs`.
 */
class m180320_114635_create_projects_progress_costs_table extends Migration
{
    const TABLE_PPC_T = '{{%projects_progress_costs_type}}';
    const TABLE_PPC = '{{%projects_progress_costs}}';

    public function safeUp()
    {

        if ($this->db->schema->getTableSchema(self::TABLE_PPC_T, true) === null) {
            $this->createTable(self::TABLE_PPC_T, [
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

            $this->insert(self::TABLE_PPC_T,['id' => 1, 'name' => 'Regular', 'created_at' => new \yii\db\Expression('NOW()')]);
            $this->insert(self::TABLE_PPC_T,['id' => 2, 'name' => 'Recoverable delay', 'created_at' => new \yii\db\Expression('NOW()')]);
            $this->insert(self::TABLE_PPC_T,['id' => 3, 'name' => 'critic', 'created_at' => new \yii\db\Expression('NOW()')]);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PPC, true) === null) {
            $this->createTable(self::TABLE_PPC, [
                'id' =>$this->primaryKey(11),
                'status' => $this->string(255)->defaultValue(null)->comment('Status'),
                'note' => $this->text()->defaultValue(null)->comment('Note'),
                'last_confirmed_time' => $this->dateTime()->null()->defaultValue(null)->comment('Last confirmed time'),
                'projects_progress_cost_type_id' => $this->integer(11)->defaultValue(null)->comment('FK to projects_progress_cost_type'),
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

            $this->addForeignKey('fk_costs_period_01', self::TABLE_PPC, 'projects_progress_detection_period_id', 'projects_progress_detection_period', 'id');
            $this->addForeignKey('fk_costs_type_01', self::TABLE_PPC, 'projects_progress_cost_type_id', 'projects_progress_costs_type', 'id');
            $this->addForeignKey('fk_costs_task_01', self::TABLE_PPC, 'projects_task_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_costs_user_01', self::TABLE_PPC, 'user_responsible_id', 'user', 'id');
        }

    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        if ($this->db->schema->getTableSchema(self::TABLE_PPC_T, true) !== null) {
            $this->dropTable(self::TABLE_PPC_T);
        }
        if ($this->db->schema->getTableSchema(self::TABLE_PPC, true) !== null) {
            $this->dropTable(self::TABLE_PPC);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}
