<?php

use yii\db\Migration;

/**
 * Class m180201_185912_add_user_to_projects_task_organization_mm
 */
class m180201_185912_add_user_to_projects_task_organization_mm extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('projects_tasks_organization_mm','user_id', $this->integer(11)->notNull()->after('projects_tasks_id'));
        $this->addForeignKey('fk_user_projects_activities_mm_2', 'projects_tasks_organization_mm','user_id', 'user', 'id');
        /** @var \yii\db\TableSchema $schema */
        $schema = $this->db->schema->getTableSchema('projects_tasks_organization_mm', true);
        if (isset($schema->foreignKeys['fk_organization_projects_tasks_mm17'])) {
            $this->dropForeignKey('fk_organization_projects_tasks_mm17', 'projects_tasks_organization_mm');
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_projects_activities_mm_2', 'projects_tasks_organization_mm');
        $this->dropColumn('projects_tasks_organization_mm', 'user_id');
        return true;
    }

}
