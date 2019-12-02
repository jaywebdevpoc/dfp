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
class m180131_173053_inser_projects_roles extends \yii\db\Migration
{
    const TABLE_PROJECTS_USER_MM = '{{%projects_user_mm}}';
    const TABLE_PROJECTS_ROLES = '{{%projects_roles}}';

    public function safeUp()
    {
        $this->insert(self::TABLE_PROJECTS_ROLES, ['name' => 'Project manager']);
        $this->insert(self::TABLE_PROJECTS_ROLES, ['name' => 'Referente partner']);

    }

    public function safeDown()
    {
        $this->delete(self::TABLE_PROJECTS_ROLES, ['name' => 'Project manager']);
        $this->delete(self::TABLE_PROJECTS_ROLES, ['name' => 'Referente partner']);
    }
}