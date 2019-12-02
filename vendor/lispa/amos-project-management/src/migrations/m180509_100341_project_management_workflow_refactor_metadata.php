<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWorkflow;

class m180509_100341_project_management_workflow_refactor_metadata extends AmosMigrationWorkflow
{

    // PER OGNI WORKFLOW ID CONST
    const PROJECTS_WORKFLOW_NAME = 'ProjectsWorkflow';
    const PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME = 'ProjectsActivityProgressWorkflow';
    const PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME = 'ProjectsDetectionPeriodWorkflow';
    const PROJECTS_MODIFY_REQUEST_NAME = 'ProjectsModifyRequestWorkflow';

    /**
     * @inheritdoc
     */
    protected function beforeAddConfs()
    {
        $this->delete('sw_metadata', 'workflow_id = "' . self::PROJECTS_WORKFLOW_NAME . '"');
        $this->delete('sw_metadata', 'workflow_id = "' . self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME . '"');
        $this->delete('sw_metadata', 'workflow_id = "' . self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME . '"');
        $this->delete('sw_metadata', 'workflow_id = "' . self::PROJECTS_MODIFY_REQUEST_NAME . '"');
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function setWorkflow()
    {

        return [
            // PROJECTS WORKFLOW
            // "CLOSED" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'CLOSED',
                'key' => 'buttonLabel',
                'value' => 'Chiudi'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'CLOSED',
                'key' => 'description',
                'value' => 'il progetto al completamento delle lavorazioni'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'CLOSED',
                'key' => 'label',
                'value' => 'Il progetto è concluso'
            ],
            // ONEDIT
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'buttonLabel',
                'value' => 'Modifica'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'description',
                'value' => 'il progetto per applicare modifiche'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'label',
                'value' => 'Sono in corso modifiche al progetto da parte del responsabile'
            ],
            // STARTUP
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STARTUP',
                'key' => 'description',
                'value' => ''
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STARTUP',
                'key' => 'label',
                'value' => 'Il progetto è in fase di configurazione, puoi creare work package ed attività'
            ],
            // VALIDATED
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'buttonLabel',
                'value' => 'Avvia il progetto'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'description',
                'value' => 'gli utenti con attività assegnate potranno iniziare le lavorazioni'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'label',
                'value' => 'Il progetto è attualmente in corso'
            ],
            // -----------------------------------------------------------

            // PROJECTS ACTIVITY PROGRESS WORKFLOW
            // "CONFIRMED" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'CONFIRMED',
                'key' => 'buttonLabel',
                'value' => 'Invia'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'CONFIRMED',
                'key' => 'description',
                'value' => 'lo stato di avanzamento'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'CONFIRMED',
                'key' => 'label',
                'value' => 'Stato di avanzamento inviato con successo'
            ],
            // ONEDIT
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'buttonLabel',
                'value' => 'Modifica'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'description',
                'value' => 'puoi apportare modifiche allo stato di avanzamento'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_PROGRESS_WORKFLOW_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'label',
                'value' => 'Puoi ancora modificare ed inviare questo stato di avanzamento'
            ],
            // -----------------------------------------------------------

            // PROJECTS DETECTION PERIOD WORKFLOW
            // "CLOSED" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'CLOSED',
                'key' => 'buttonLabel',
                'value' => 'Chiudi'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'CLOSED',
                'key' => 'description',
                'value' => 'il periodo di rilevazione'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'CLOSED',
                'key' => 'label',
                'value' => 'Il periodo di rilevazione è concluso'
            ],
            // INPROGRESS
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'INPROGRESS',
                'key' => 'buttonLabel',
                'value' => 'Avvia'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'INPROGRESS',
                'key' => 'description',
                'value' => 'il periodo di rilevazione'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'INPROGRESS',
                'key' => 'label',
                'value' => 'Il periodo di rilevazione è aperto ed attualmente in corso'
            ],
            // PLANNED
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'PLANNED',
                'key' => 'buttonLabel',
                'value' => 'Salva'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'PLANNED',
                'key' => 'description',
                'value' => 'il periodo di rilevazione'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_ACTIVITY_DETECTION_PERIOD_NAME,
                'status_id' => 'PLANNED',
                'key' => 'label',
                'value' => 'Il periodo di rilevazione è stato pianificato con successo'
            ],
            // -----------------------------------------------------------

            // PROJECTS MODIFY REQUEST WORKFLOW
            // "CLOSED" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'CLOSED',
                'key' => 'buttonLabel',
                'value' => 'Archivia'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'CLOSED',
                'key' => 'description',
                'value' => 'dopo aver applicato tutte le modifiche, puoi archiviare la richiesta'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'CLOSED',
                'key' => 'label',
                'value' => 'La richiesta di modifica risulta completata. Le richieste sono state applicate con successo'
            ],
            // ONEDIT
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'buttonLabel',
                'value' => 'Modifica'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'description',
                'value' => 'puoi apportare modifiche alla scheda'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'ONEDIT',
                'key' => 'label',
                'value' => 'Puoi ancora modificare e inviare questa richiesta di modifica'
            ],
            // REJECTED
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'REJECTED',
                'key' => 'buttonLabel',
                'value' => 'Rifiuta'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'REJECTED',
                'key' => 'description',
                'value' => 'la richiesta di modifica e richiedi integrazioni all\'utente'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'REJECTED',
                'key' => 'label',
                'value' => 'La richista di modifica è stata rifiutata'
            ],
            // TOVALIDATE
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'TOVALIDATE',
                'key' => 'buttonLabel',
                'value' => 'Invia'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'TOVALIDATE',
                'key' => 'description',
                'value' => 'la richiesta di modifica'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'TOVALIDATE',
                'key' => 'label',
                'value' => 'La richiesta di modifica è in attesa di approvazione'
            ],
            // VALIDATED
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'buttonLabel',
                'value' => 'Valida'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'description',
                'value' => 'ricordati di applicare le richieste di modifica pervenute'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'label',
                'value' => 'La richiesta di modifica è stata accettata'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'OLD-ONEDIT_description',
                'key' => 'description',
                'value' => 'Conferma la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'OLD-ONEDIT_label',
                'key' => 'label',
                'value' => 'Confirm modify request'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_MODIFY_REQUEST_NAME,
                'status_id' => 'VALIDATED',
                'key' => 'OLD-TOVALIDATE_description',
                'value' => 'Approva la richiesta per iniziare ad aggiornare il piano delle attività, come richiesto'
            ],
            // -----------------------------------------------------------
        ];
    }
}
