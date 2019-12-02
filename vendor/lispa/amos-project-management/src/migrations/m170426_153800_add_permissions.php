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
use yii\db\Schema;

/**
 * Default migration for the `project_management` Application Project
 */
class m170426_153800_add_permissions extends \yii\db\Migration
{

    const TABLE_ASSIGNMENT_AMOS = '{{%auth_assignment}}';
    const TABLE_RULE_AMOS = '{{%auth_rule}}';
    const TABLE_PERMISSION_AMOS = '{{%auth_item}}';
    const TABLE_PERMISSION_CHILD_AMOS = '{{%auth_item_child}}';
    const TABLE_USER_AMOS = '{{%user}}';
    const TABLE_WIDGET_AMOS = '{{%widgets}}';
    const TABLE_AMOS_USER_PROFILE = '{{%user_profile}}';

    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");

        if ($this->db->schema->getTableSchema(self::TABLE_PERMISSION_AMOS,
                true) !== null && $this->db->schema->getTableSchema(self::TABLE_PERMISSION_CHILD_AMOS, true) !== null) {
            $this->insert(self::TABLE_PERMISSION_AMOS, [
                'name' => 'PROJECTSCUSTOMSPENDINGVOICES_READ',
                'type' => '2',
                'description' => 'Permesso di read sul model ProjectsActivities'
            ]);
            $this->insert(self::TABLE_PERMISSION_CHILD_AMOS, [
                'parent' => 'ADMIN',
                'child' => 'PROJECTSCUSTOMSPENDINGVOICES_READ'
            ]);
            $this->insert(self::TABLE_PERMISSION_AMOS, [
                'name' => 'PROJECTSCUSTOMSPENDINGVOICES_CREATE',
                'type' => '2',
                'description' => 'Permesso di create sul model ProjectsActivities'
            ]);
            $this->insert(self::TABLE_PERMISSION_CHILD_AMOS, [
                'parent' => 'ADMIN',
                'child' => 'PROJECTSCUSTOMSPENDINGVOICES_CREATE'
            ]);
            $this->insert(self::TABLE_PERMISSION_AMOS, [
                'name' => 'PROJECTSCUSTOMSPENDINGVOICES_UPDATE',
                'type' => '2',
                'description' => 'Permesso di update sul model ProjectsActivities'
            ]);
            $this->insert(self::TABLE_PERMISSION_CHILD_AMOS, [
                'parent' => 'ADMIN',
                'child' => 'PROJECTSCUSTOMSPENDINGVOICES_UPDATE'
            ]);
            $this->insert(self::TABLE_PERMISSION_AMOS, [
                'name' => 'PROJECTSCUSTOMSPENDINGVOICES_DELETE',
                'type' => '2',
                'description' => 'Permesso di delete sul model ProjectsActivities'
            ]);
            $this->insert(self::TABLE_PERMISSION_CHILD_AMOS, [
                'parent' => 'ADMIN',
                'child' => 'PROJECTSCUSTOMSPENDINGVOICES_DELETE'
            ]);

            $this->insert(self::TABLE_PERMISSION_CHILD_AMOS, [
                'parent' => 'PROJECT_MANAGER',
                'child' => 'PROJECTSCUSTOMSPENDINGVOICES_CREATE'
            ]);
        }

        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function safeDown()
    {
        return false;
    }
}