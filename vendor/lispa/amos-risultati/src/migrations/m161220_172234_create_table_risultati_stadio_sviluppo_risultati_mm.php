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
 * Class m161220_172234_create_table_risultati_stadio_sviluppo_risultati_mm
 */
class m161220_172234_create_table_risultati_stadio_sviluppo_risultati_mm extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati_stadio_sviluppo_risultati_mm}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'risultati_id' => $this->integer()->notNull(),
            'stadio_sviluppo_risultati_id' => $this->integer()->notNull()
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
        $this->addForeignKey('fk_risultati_stadio_sviluppo_risultati_mm11', $this->tableName, 'risultati_id', 'risultati', 'id');
        $this->addForeignKey('fk_stadio_sviluppo_risultati_risultati_mm11', $this->tableName, 'stadio_sviluppo_risultati_id', 'stadio_sviluppo_risultati', 'id');
    }
}
