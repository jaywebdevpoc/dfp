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
 * Class m161220_172244_create_table_risultati_protezione_innovazione_risultati_mm
 */
class m161220_172244_create_table_risultati_protezione_innovazione_risultati_mm extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati_protezione_innovazione_risultati_mm}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'risultati_id' => $this->integer()->notNull(),
            'protezione_innovazione_risultati_id' => $this->integer()->notNull()
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
        $this->addForeignKey('fk_risultati_protezione_innovazione_risultati_mm12', $this->tableName, 'risultati_id', 'risultati', 'id');
        $this->addForeignKey('fk_protezione_innovazione_risulta_risultati_mm12', $this->tableName, 'protezione_innovazione_risultati_id', 'protezione_innovazione_risultati', 'id');
    }
}
