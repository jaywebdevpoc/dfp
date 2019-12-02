<?php

use yii\db\Migration;

class m180321_165619_add_projects_progress_costs_type_values extends Migration
{
    public function safeUp()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;");
        $this->truncateTable('projects_progress_costs_type');
        $this->execute("SET FOREIGN_KEY_CHECKS=1;");
        $this->insert('projects_progress_costs_type',[
            'id' => 1,
            'name' => 'Under the forecast', // Sotto la previsione
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);
        $this->insert('projects_progress_costs_type',[
            'id' => 2,
            'name' => 'In line with the forecasts', // In linea con le previsioni
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);
        $this->insert('projects_progress_costs_type',[
            'id' => 3,
            'name' => 'Above the forecast (recoverable)', // Sopra le previsioni (recuperabile)
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);
        $this->insert('projects_progress_costs_type',[
            'id' => 4,
            'name' => 'Above the forecasts (critical)', // Sopra le previsioni (critico)
            'created_at' => new \yii\db\Expression('NOW()'),
        ]);
    }

    public function safeDown()
    {
        // do nothing
    }

}
