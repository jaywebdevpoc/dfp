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

class m150802_000004_insert_faq_categories extends \yii\db\Migration {

    const TABLE = '{{%faq_categories}}';

    public function safeUp() {
        $this->insert(self::TABLE, [
            'id' => '1',
            'titolo' => 'Widget grafici',
            'descrizione' => ''
        ]);

        $this->insert(self::TABLE, [
            'id' => '2',
            'titolo' => 'WIdget a icona',
            'descrizione' => ''
        ]);
    }

    public function safeDown() {
        $this->execute("SET FOREIGN_KEY_CHECKS = 0;");
        $this->delete(self::TABLE, ['id' => '1']);
        $this->delete(self::TABLE, ['id' => '2']);
        $this->execute("SET FOREIGN_KEY_CHECKS = 1;");
    }

}
