<?php
use yii\db\Migration;

/**
 * Class m180214_103312_remove_old_workflow_and_permission_projects
 */
class m180216_103312_create_workflow_projects_modify_request extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // new workflow
        $this->insert('sw_workflow', ['id' => 'ProjectsModifyRequestWorkflow', 'initial_status_id' => 'ONEDIT']);

        // new workflow
        $this->insert('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'On edit', 'sort_order' => 1]);
        $this->insert('sw_status', ['id' => 'TOVALIDATE', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'To validate', 'sort_order' => 2]);
        $this->insert('sw_status', ['id' => 'VALIDATED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Validated', 'sort_order' => 3]);
        $this->insert('sw_status', ['id' => 'REJECTED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Rejected', 'sort_order' => 4]);
        $this->insert('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Closed', 'sort_order' => 5]);

        // new workflow
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'VALIDATED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'TOVALIDATE']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'ONEDIT']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'VALIDATED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'CLOSED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'REJECTED']);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // new workflow
        $this->delete('sw_workflow', ['id' => 'ProjectsModifyRequestWorkflow', 'initial_status_id' => 'ONEDIT']);

        // new workflow
        $this->delete('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'On edit', 'sort_order' => 1]);
        $this->delete('sw_status', ['id' => 'TOVALIDATE', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'To validate', 'sort_order' => 2]);
        $this->delete('sw_status', ['id' => 'VALIDATED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Validated', 'sort_order' => 3]);
        $this->delete('sw_status', ['id' => 'REJECTED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Rejected', 'sort_order' => 4]);
        $this->delete('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsModifyRequestWorkflow', 'label' => 'Closed', 'sort_order' => 5]);

        // new workflow
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'VALIDATED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'TOVALIDATE']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'ONEDIT']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'VALIDATED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'CLOSED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsModifyRequestWorkflow','start_status_id' => 'TOVALIDATE', 'end_status_id' => 'REJECTED']);

    }

}
