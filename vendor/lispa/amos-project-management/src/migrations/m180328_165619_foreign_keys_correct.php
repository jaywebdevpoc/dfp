<?php

use yii\db\Migration;

class m180328_165619_foreign_keys_correct extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\db\TableSchema $schema */
        $schema = $this->db->schema->getTableSchema('projects_activities_organization_mm', true);
        if (isset($schema->foreignKeys['fk_organization_projects_activities_mm15'])) {
            $this->dropForeignKey('fk_organization_projects_activities_mm15', 'projects_activities_organization_mm');
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }

}
