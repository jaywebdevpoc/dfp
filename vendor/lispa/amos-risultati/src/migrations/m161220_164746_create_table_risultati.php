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
 * Class m161220_164746_create_table_risultati
 */
class m161220_164746_create_table_risultati extends AmosMigrationTableCreation
{
    /**
     * @inheritdoc
     */
    protected function setTableName()
    {
        $this->tableName = '{{%risultati}}';
    }

    /**
     * @inheritdoc
     */
    protected function setTableFields()
    {
        $this->tableFields = [
            'id' => $this->primaryKey(),
            'stato' => $this->string(255)->null()->comment('Stato'),
            'titolo_dellinnovazione' => $this->string(255)->notNull()->comment('Titolo dell’innovazione'),
            'sommario' => $this->text()->notNull()->comment('Sommario'),
            'e_una_innovazione_prevalenteme' => $this->string(255)->notNull()->comment('E’ una innovazione prevalentemente di'),
            'coerenza_ads_tag' => $this->integer()->null()->comment('Coerenza ADS (TAG)'),
            'referente' => $this->integer()->notNull()->comment('Referente'),
            'sito_web_per_approfondimento_p' => $this->string(255)->null()->comment('Sito web per approfondimento progetto'),
            'cosa_ce_oggi_che_prima_non_cer' => $this->text()->notNull()->comment('Cosa c’è oggi che prima non c’era'),
            'e_importante_sapere_anche_ques' => $this->text()->null()->comment('E’ importante sapere anche questo…'),
            'qual_e_attualmente_il_mercato_' => $this->text()->notNull()->comment('Qual è attualmente il mercato di riferimento?'),
            'ce_un_mercato_geografico_di_ri' => $this->text()->notNull()->comment('C’è un mercato geografico di riferimento spec'),
            'in_che_modo_il_lavoro_in_partn' => $this->text()->notNull()->comment('In che modo il lavoro in partnership ha reso'),
            'qual_e_laziendaorganismo_di_ri' => $this->integer()->notNull()->comment('Qual è l’azienda/organismo di ricerca titolar'),
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
        $this->addForeignKey('fk_risultati_innovazione_prevalente_risultati', $this->getRawTableName(), 'e_una_innovazione_prevalenteme', 'risultati_innovazione_prevalente', 'id');
    }
}
