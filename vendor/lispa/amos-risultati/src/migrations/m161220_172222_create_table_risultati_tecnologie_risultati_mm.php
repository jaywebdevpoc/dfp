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

class m161220_172222_create_table_risultati_tecnologie_risultati_mm extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati_tecnologie_risultati_mm}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'risultati_id' => $this->integer()->notNull(),
            'tecnologie_risultati_id' => $this->integer()->notNull()
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
        $this->addForeignKey('fk_risultati_tecnologie_risultati_mm10', $this->tableName, 'risultati_id', 'risultati', 'id');
        $this->addForeignKey('fk_tecnologie_risultati_risultati_mm10', $this->tableName, 'tecnologie_risultati_id', 'tecnologie_risultati', 'id');
    }
}
