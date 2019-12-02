<?php

use yii\db\Migration;

/**
 * Class m180222_144007_crete_workflow_detection_period_and_progress_activities
 */
class m180416_115807_metadata_workflow_modify_request extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $this->insert('sw_metadata', ['key' => 'ONEDIT_label', 'value' => 'Confirm modify request','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->insert('sw_metadata', ['key' => 'ONEDIT_description', 'value' => 'Conferma la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->insert('sw_metadata', ['key' => 'TOVALIDATE_description', 'value' => 'Approva la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->update('sw_metadata', ['value' => 'Confirm modify request'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'TOVALIDATE', 'key' => 'buttonLabel',]);
        $this->insert('sw_metadata', ['key' => 'description', 'value' => 'Presenta la richiesta di modifica al project manager','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'TOVALIDATE']);
        $this->update('sw_metadata', ['value' => 'Approve'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED', 'key' => 'buttonLabel']);
        $this->update('sw_metadata', ['value' => 'Respingi la richiesta'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'REJECTED', 'key' => 'buttonLabel']);
        $this->insert('sw_metadata', ['key' => 'description', 'value' => 'Rigetta la richiesta di modifica al piano delle attività, se non è necessaria','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'REJECTED']);
        $this->insert('sw_metadata', ['key' => 'description', 'value' => 'Richiedi una correzione alla richiesta di modifica','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'ONEDIT']);
        $this->update('sw_metadata', ['value' => 'Require modification'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'ONEDIT', 'key' => 'buttonLabel']);
        $this->update('sw_metadata', ['value' => 'Approved'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED', 'key' => 'label']);


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

        $this->delete('sw_metadata', ['key' => 'ONEDIT_label', 'value' => 'Confirm modify request','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->delete('sw_metadata', ['key' => 'ONEDIT_description', 'value' => 'Conferma la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->delete('sw_metadata', ['key' => 'TOVALIDATE_description', 'value' => 'Approva la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED']);
        $this->update('sw_metadata', ['value' => 'Invia richiesta di modifica al piano'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'TOVALIDATE', 'key' => 'buttonLabel',]);
        $this->delete('sw_metadata', ['key' => 'description', 'value' => 'Presenta la richiesta di modifica al project manager','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'TOVALIDATE']);
        $this->update('sw_metadata', ['value' => 'Validated'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'TOVALIDATE', 'key' => 'buttonLabel']);
        $this->update('sw_metadata', ['value' => 'Rejected'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'REJECTED', 'key' => 'buttonLabel']);
        $this->delete('sw_metadata', ['key' => 'description', 'value' => 'Rigetta la richiesta di modifica al piano delle attività, se non è necessaria','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'REJECTED']);
        $this->delete('sw_metadata', ['key' => 'description', 'value' => 'Richiedi una correzione alla richiesta di modifica','workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'ONEDIT']);
        $this->update('sw_metadata', ['value' => 'On edit'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'ONEDIT', 'key' => 'buttonLabel']);
        $this->update('sw_metadata', ['value' => 'Validated'], ['workflow_id' => 'ProjectsModifyRequestWorkflow', 'status_id' => 'VALIDATED', 'key' => 'label']);

    }

}
