<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\migration\AmosMigrationTableCreation;

/**
 * Class m161220_172253_create_table_risultati_bisogno_per_sviluppo_risultati_mm
 */
class m161220_172253_create_table_risultati_bisogno_per_sviluppo_risultati_mm extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati_bisogno_per_sviluppo_risultati_mm}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'risultati_id' => $this->integer()->notNull(),
            'bisogno_per_sviluppo_risultati_id' => $this->integer()->notNull()
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

    /**
     * @inheritdoc
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey('fk_risultati_bisogno_per_sviluppo_risultati_mm13', $this->tableName, 'risultati_id', 'risultati', 'id');
        $this->addForeignKey('fk_bisogno_per_sviluppo_risultati_risultati_mm13', $this->tableName, 'bisogno_per_sviluppo_risultati_id', 'bisogno_per_sviluppo_risultati', 'id');
    }
}
