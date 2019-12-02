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
 * Class m170509_094801_tasks_costs_table
 */
class m170509_094801_tasks_costs_table extends \lispa\amos\core\migration\AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%projects_tasks_costs}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'projects_tasks_id' => $this->integer()->notNull()->comment('Task'),
            'projects_custom_spending_voices_id' => $this->integer()->notNull()->comment('Spending Voice'),
            'organization_id' => $this->integer()->notNull()->comment('Organization'),
            'value' => $this->integer()->null()->comment('Value')
        ];
    }

    /**
     * @inheritdoc
     */
    protected function beforeTableCreation()
    {
        parent::beforeTableCreation();
        $this->setAddCreatedUpdatedFields(true);
    }
}
