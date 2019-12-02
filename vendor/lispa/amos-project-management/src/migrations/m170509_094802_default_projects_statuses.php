<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

/**
 * Class m170509_094802_default_projects_statuses
 */

use lispa\amos\projectmanagement\Module;

class m170509_094802_default_projects_statuses extends \yii\db\Migration
{
    const STATES_TABLE = 'projects_states';

    public function safeUp()
    {
        $this->insert(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'Preparing')]);
        $this->insert(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'In Progress')]);
        $this->insert(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'Completed')]);

        return true;
    }

    public function safeDown()
    {
        $this->delete(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'Preparing')]);
        $this->delete(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'In Progress')]);
        $this->delete(self::STATES_TABLE, ['name' => Module::t('amosproject_management', 'Completed')]);
        return true;
    }
}
