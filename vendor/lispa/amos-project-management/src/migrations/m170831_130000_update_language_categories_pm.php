<?php

use yii\db\Migration;

class m170831_130000_update_language_categories_pm extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        try {
            $this->update('language_source', ['category' => 'amosproject_management',], ['category' => 'amosprojectmanagement']);
            $this->update('language_source', ['category' => 'amosproject_management',], ['category' => 'amosproject_manager']);
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
