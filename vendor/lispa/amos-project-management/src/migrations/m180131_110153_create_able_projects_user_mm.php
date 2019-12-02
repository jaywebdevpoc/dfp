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
class m180131_110153_create_able_projects_user_mm extends \yii\db\Migration
{
    const TABLE_PROJECTS_USER_MM = '{{%projects_user_mm}}';
    const TABLE_PROJECTS_ROLES = '{{%projects_roles}}';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");


        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ROLES, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_ROLES, [
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

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_USER_MM, true) === null) {

            $this->createTable(self::TABLE_PROJECTS_USER_MM, [
                'id' => Schema::TYPE_PK,
                'projects_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT 'Project'",
                'user_id' => Schema::TYPE_INTEGER . " NOT NULL COMMENT 'User'",
                'projects_role_id' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Role'",
                'organization_id' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Organization'",
                'created_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Creato il'",
                'updated_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Aggiornato il'",
                'deleted_at' => Schema::TYPE_DATETIME . " NULL DEFAULT NULL COMMENT 'Cancellato il'",
                'created_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Creato da'",
                'updated_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Aggiornato da'",
                'deleted_by' => Schema::TYPE_INTEGER . " NULL DEFAULT NULL COMMENT 'Cancellato da'",
            ],
                $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT=1' : null);
            $this->addForeignKey('fk_projects_user_mm_projects_id1', 'projects_user_mm', 'projects_id', 'projects', 'id');
            $this->addForeignKey('fk_projects_user_mm_user_id1', 'projects_user_mm', 'user_id', 'user', 'id');
            $this->addForeignKey('fk_projects_user_mm_projects_role_id1', 'projects_user_mm', 'projects_role_id', 'projects_roles', 'id');
        }



        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function safeDown()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_USER_MM, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_USER_MM);
        }

        if ($this->db->schema->getTableSchema(self::TABLE_PROJECTS_ROLES, true) !== null) {
            $this->dropTable(self::TABLE_PROJECTS_ROLES);
        }

        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }
}