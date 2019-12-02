<?php

use yii\db\Migration;

class m170831_121800_update_language_categories_pm extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        try {
            $this->update('language_source', ['category' => 'amosprojectmanagement',], ['category' => 'amosprojectmanagement8']);
            $this->update('language_source', ['category' => 'amosprojectmanagement',], ['category' => 'projectmanagement']);
            $this->update('language_source', ['category' => 'amosgantt',], ['category' => 'amos/gantt']);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return true;
    }
}
