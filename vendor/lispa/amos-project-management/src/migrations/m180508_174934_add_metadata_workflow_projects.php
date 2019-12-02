<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;

class m180508_174934_add_metadata_workflow_projects extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'message', 'value' => "Mentre il progetto e' in corso, tutte le informazioni ed il piano di attivita' saranno modificabili solo a seguito di una richiesta di modifica. Confermi l'avvio del progetto ?"]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'message', 'value' => "Mentre il progetto e' in corso, tutte le informazioni ed il piano di attivita' saranno modificabili solo a seguito di una richiesta di modifica. Confermi l'avvio del progetto ?"]);

    }
}
