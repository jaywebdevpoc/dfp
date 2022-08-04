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
 * Class m161220_165421_create_table_tecnologie_risultati
 */
class m161220_165421_create_table_tecnologie_risultati extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%tecnologie_risultati}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'denominazione' => $this->string(255)->notNull()->comment('Denominazione'),
            'descrizione' => $this->text()->null()->comment('Descrizione')
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
