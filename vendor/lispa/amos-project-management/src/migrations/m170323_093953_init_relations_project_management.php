<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use yii\db\Query;
use yii\db\Schema;

/**
 * Class m170323_093953_init_relations_project_management
 */
class m170323_093953_init_relations_project_management extends \yii\db\Migration
{
    const TABLE_ASSIGNMENT_AMOS = '{{%auth_assignment}}';
    const TABLE_RULE_AMOS = '{{%auth_rule}}';
    const TABLE_PERMISSION_AMOS = '{{%auth_item}}';
    const TABLE_PERMISSION_CHILD_AMOS = '{{%auth_item_child}}';
    const TABLE_USER_AMOS = '{{%user}}';
    const TABLE_WIDGET_AMOS = '{{%widgets}}';

    const TABLE_PROJECTS_PROJECTS_STATES_MM = '{{%projects_projects_states_mm}}';


    const TABLE_PROJECTS_ORGANIZATION_MM = '{{%projects_organization_mm}}';


    const TABLE_PROJECTS_PROJECTS_MEASURE_MM = '{{%projects_projects_measure_mm}}';


    const TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM = '{{%projects_activities_projects_mm}}';


    const TABLE_projects_activities_organization_mm = '{{%projects_activities_organization_mm}}';


    const TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM = '{{%projects_tasks_projects_activities_mm}}';


    const TABLE_PROJECTS_TASKS_ORGANIZATION_MM = '{{%projects_tasks_organization_mm}}';


    const TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM = '{{%projects_tasks_projects_task_statuses_mm}}';


    const TABLE_PROJECTS_TASKS_TASKS_MM = '{{%projects_tasks_tasks_mm}}';

    /**
     * @var string $migrationTable
     */
    private $migrationTable = '{{%migration}}';

    /**
     * @var string $oldMigrationName
     */
    private $oldMigrationName = 'm170323_093753_init_relations_project_management';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $query = new Query();
        $query->from($this->migrationTable);
        $query->andWhere(['like', 'version', $this->oldMigrationName]);
        $exists = $query->exists();
        if ($exists) {
            $this->delete($this->migrationTable, ['version' => $this->oldMigrationName]);
            return true;
        }

        $this->execute("SET FOREIGN_KEY_CHECKS=0;");

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_PROJECTS_STATES_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_PROJECTS_STATES_MM, [
                'id' => Schema::TYPE_PK,
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'projects_states_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_projects_states_mm10', self::TABLE_PROJECTS_PROJECTS_STATES_MM, 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_projects_states_projects_mm10', self::TABLE_PROJECTS_PROJECTS_STATES_MM, 'projects_states_id', 'projects_states', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ORGANIZATION_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_ORGANIZATION_MM, [
                'id' => Schema::TYPE_PK,
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'organization_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_organization_mm11', self::TABLE_PROJECTS_ORGANIZATION_MM, 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_organization_projects_mm11', self::TABLE_PROJECTS_ORGANIZATION_MM, 'organization_id', 'aziende', 'id');
        }

        if ($this->db->schema->getTableSchema('{{%projects_joined_organization_mm}}', true) === null) {
            $this->createTable(('{{%projects_joined_organization_mm}}'), [
                'id' => Schema::TYPE_PK,
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'organization_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_organization_mm102', '{{%projects_joined_organization_mm}}', 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_organization_projects_mm102', '{{%projects_joined_organization_mm}}', 'organization_id', 'aziende', 'id');
        }

        if ($this->db->schema->getTableSchema('{{%projects_tasks_joined_organization_mm}}', true) === null) {
            $this->createTable(('{{%projects_tasks_joined_organization_mm}}'), [
                'id' => Schema::TYPE_PK,
                'projects_tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'organization_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            //$this->addForeignKey('fk_projects_organization_mm102', '{{%projects_tasks_joined_organization_mm}}', 'projects_tasks_id', 'projects_tasks', 'id');
            //$this->addForeignKey('fk_organization_projects_mm102', '{{%projects_tasks_joined_organization_mm}}', 'organization_id', 'aziende', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_PROJECTS_MEASURE_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_PROJECTS_MEASURE_MM, [
                'id' => Schema::TYPE_PK,
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'projects_measure_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_projects_measure_mm13', self::TABLE_PROJECTS_PROJECTS_MEASURE_MM, 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_projects_measure_projects_mm13', self::TABLE_PROJECTS_PROJECTS_MEASURE_MM, 'projects_measure_id', 'projects_measure', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM, [
                'id' => Schema::TYPE_PK,
                'projects_activities_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_activities_projects_mm14', self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM, 'projects_activities_id', 'projects_activities', 'id');
            $this->addForeignKey('fk_projects_projects_activities_mm14', self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM, 'projects_id', 'projects', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_projects_activities_organization_mm, true) === null) {
            $this->createTable(self::TABLE_projects_activities_organization_mm, [
                'id' => Schema::TYPE_PK,
                'projects_activities_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'organization_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_activities_organization_mm15', self::TABLE_projects_activities_organization_mm, 'projects_activities_id', 'projects_activities', 'id');
            $this->addForeignKey('fk_organization_projects_activities_mm15', self::TABLE_projects_activities_organization_mm, 'organization_id', 'aziende', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM, [
                'id' => Schema::TYPE_PK,
                'projects_tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'projects_activities_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_tasks_projects_activities_mm16', self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM, 'projects_tasks_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_projects_activities_projects_tasks_mm16', self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM, 'projects_activities_id', 'projects_activities', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM, [
                'id' => Schema::TYPE_PK,
                'projects_tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'organization_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_tasks_organization_mm17', self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM, 'projects_tasks_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_organization_projects_tasks_mm17', self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM, 'organization_id', 'aziende', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM, [
                'id' => Schema::TYPE_PK,
                'projects_tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'projects_task_statuses_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            $this->addForeignKey('fk_projects_tasks_projects_task_statuses_mm18', self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM, 'projects_tasks_id', 'projects_tasks', 'id');
            $this->addForeignKey('fk_projects_task_statuses_projects_tasks_mm18', self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM, 'projects_task_statuses_id', 'projects_task_statuses', 'id');
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_TASKS_MM, true) === null) {
            $this->createTable(self::TABLE_PROJECTS_TASKS_TASKS_MM, [
                'id' => Schema::TYPE_PK,
                'projects_tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'tasks_id' => Schema::TYPE_INTEGER . " NOT NULL",
                'type' => "enum('finish_to_finish','finish_to_start','start_to_finish','start_to_start') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'finish_to_start'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            //Aggiungiamo le chiavi esterne
            //$this->addForeignKey('fk_projects_tasks_tasks_mm19', self::TABLE_PROJECTS_TASKS_TASKS_MM, 'projects_tasks_id', 'projects_tasks', 'id');
            //$this->addForeignKey('fk_tasks_projects_tasks_mm19', self::TABLE_PROJECTS_TASKS_TASKS_MM, 'tasks_id', 'projects_tasks', 'id');
        }

        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_PROJECTS_STATES_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_PROJECTS_STATES_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ORGANIZATION_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_ORGANIZATION_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_PROJECTS_MEASURE_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_PROJECTS_MEASURE_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_ACTIVITIES_PROJECTS_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_projects_activities_organization_mm, true) !== null) {
            $this->dropTable(self::TABLE_projects_activities_organization_mm);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASKS_PROJECTS_ACTIVITIES_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASKS_ORGANIZATION_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASKS_PROJECTS_TASK_STATUSES_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_TASKS_TASKS_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_TASKS_TASKS_MM);
        }
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}
