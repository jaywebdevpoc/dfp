<?php

use yii\db\Migration;

class m180320_104746_add_user_responsible_costs_to_projects_tasks extends Migration
{
    public function safeUp()
    {
        $this->addColumn('projects_tasks','user_responsible_costs_id',$this->integer(11)->defaultValue(null)->comment('User responsible costs')->after('status'));
    }

    public function safeDown()
    {
        $this->dropColumn('projects_tasks','user_responsible_costs_id');
    }
}
