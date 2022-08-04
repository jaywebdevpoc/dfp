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

use yii\db\Schema;

class m161108_080007_alter_faq extends \yii\db\Migration {

    const TABLE = '{{%faq}}';

    public function safeUp() {
        if ($this->db->schema->getTableSchema(self::TABLE, true) !== null) {           
            $this->dropForeignKey('fk_faq_faq_widgets1', self::TABLE);
            $this->dropIndex('fk_faq_faq_widgets1', self::TABLE);
            $this->dropColumn(self::TABLE, 'faq_widgets_id');                     
        } else {
            echo "Nessuna operazion eseguita in quanto la tabella non esiste";
            return true;
        }
    }

    public function safeDown() {
        echo "Nessuna cancellazione eseguita";
        return true;
    }

}
