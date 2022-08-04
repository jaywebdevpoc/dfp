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
 * Class m161220_164546_create_table_risultati_innovazione_prevalente
 */
class m161220_164546_create_table_risultati_innovazione_prevalente extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati_innovazione_prevalente}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->string(255)->notNull()->comment('ID'),
            'nome' => $this->string(255)->notNull()->comment('Nome'),
            'ordinal' => $this->smallInteger()->notNull()
        ];
    }

    /**
     * Override to make operations after the table creation.
     */
    protected function afterTableCreation()
    {
        $this->addPrimaryKey('', $this->getRawTableName(), 'id');
    }

    /**
     * Override to make operations after adding foreign keys.
     */
    protected function afterForeignKeysAdd()
    {
        $this->insert($this->getRawTableName(), [
            'id' => 'PRODOTTO',
            'nome' => 'Prodotto',
            'ordinal' => '1'
        ]);

        $this->insert($this->getRawTableName(), [
            'id' => 'PROCESSO',
            'nome' => 'Processo',
            'ordinal' => '2'
        ]);

        $this->insert($this->getRawTableName(), [
            'id' => 'SERVIZIO',
            'nome' => 'Servizio',
            'ordinal' => '3'
        ]);

        $this->insert($this->getRawTableName(), [
            'id' => 'ALTRO',
            'nome' => 'Altro',
            'ordinal' => '4'
        ]);
    }
}
