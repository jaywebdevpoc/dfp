<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;

/**
 * Class m180219_142008_create_metadata_button_label_projects_modify_request
 */
class m180219_142008_create_metadata_button_label_projects_modify_request extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->delete('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW]);

        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'label', 'value' => 'On edit']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'TOVALIDATE', 'key' => 'label', 'value' => 'To validate']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'label', 'value' => 'Validated']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'REJECTED', 'key' => 'label', 'value' => 'Rejected']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'label', 'value' => 'Closed']);

        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'TOVALIDATE', 'key' => 'buttonLabel', 'value' => 'Invia richiesta di modifica al piano']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'buttonLabel', 'value' => 'Validated']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'REJECTED', 'key' => 'buttonLabel', 'value' => 'Rejected']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'buttonLabel', 'value' => 'Closed']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'buttonLabel', 'value' => 'On edit']);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_metadata', ['workflow_id' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW]);
    }
}
