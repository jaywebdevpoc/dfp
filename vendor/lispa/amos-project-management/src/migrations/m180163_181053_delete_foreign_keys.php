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
class m180163_181053_delete_foreign_keys extends \yii\db\Migration
{

    public function safeUp()
    {
        if (isset($schema->foreignKeys['fk_organization_projects_mm102'])) {
            $this->dropForeignKey('fk_organization_projects_mm102','projects_joined_organization_mm');
        }
        if (isset($schema->foreignKeys['fk_organization_projects_activities_mm15'])) {
            $this->dropForeignKey('fk_organization_projects_activities_mm15','projects_activities_organization_mm');
        }

    }

    public function safeDown()
    {
        return true;
    }
}