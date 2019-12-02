<?php

use yii\db\Migration;

/**
 * Class m180201_085912_add_user_to_projects_activities_organization_mm
 */
class m180201_085912_add_user_to_projects_activities_organization_mm extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('projects_activities_organization_mm','user_id', $this->integer(11)->notNull()->after('projects_activities_id'));
        $this->addForeignKey('fk_user_projects_activities_mm_1', 'projects_activities_organization_mm','user_id', 'user', 'id');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_projects_activities_mm_1', 'projects_activities_organization_mm');
        $this->dropColumn('projects_activities_organization_mm', 'user_id');
        return true;
    }

}
