<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

class m150802_000002_insert_faq_stato extends \yii\db\Migration {

    const TABLE = '{{%faq_stato}}';

    public function safeUp() {
        $this->insert(self::TABLE, [
            'id' => '1',
            'nome' => 'BOZZA',
            'descrizione' => 'Modifica in corso'
        ]);

        $this->insert(self::TABLE, [
            'id' => '2',
            'nome' => 'DA_VALIDARE',
            'descrizione' => 'Da validare'
        ]);

        $this->insert(self::TABLE, [
            'id' => '3',
            'nome' => 'VALIDATO',
            'descrizione' => 'Validato'
        ]);

        $this->insert(self::TABLE, [
            'id' => '4',
            'nome' => 'NON_VALIDATO',
            'descrizione' => 'Non validato'
        ]);
    }

    public function safeDown() {
        $this->delete(self::TABLE, ['id' => '1']);
        $this->delete(self::TABLE, ['id' => '2']);
        $this->delete(self::TABLE, ['id' => '3']);
        $this->delete(self::TABLE, ['id' => '4']);
    }

}
