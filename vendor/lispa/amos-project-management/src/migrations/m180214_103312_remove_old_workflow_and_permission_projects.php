<?php
use yii\db\Migration;

/**
 * Class m180214_103312_remove_old_workflow_and_permission_projects
 */
class m180214_103312_remove_old_workflow_and_permission_projects extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // existing workflow to delete
        $this->delete('sw_workflow', ['id' => 'ProjectsWorkflow']);
        // new workflow
        $this->insert('sw_workflow', ['id' => 'ProjectsWorkflow', 'initial_status_id' => 'STARTUP']);

        // existing workflow to delete
        $this->delete('sw_status', ['workflow_id' => 'ProjectsWorkflow']);
        // new workflow
        $this->insert('sw_status', ['id' => 'STARTUP', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Startup', 'sort_order' => 1]);
        $this->insert('sw_status', ['id' => 'VALIDATED', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Validated', 'sort_order' => 2]);
        $this->insert('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'On edit', 'sort_order' => 3]);
        $this->insert('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Closed', 'sort_order' => 4]);

        // existing workflow to delete
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsWorkflow']);
        // new workflow
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'STARTUP', 'end_status_id' => 'VALIDATED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'ONEDIT']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'CLOSED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'VALIDATED']);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_workflow', ['id' => 'ProjectsWorkflow']);

        $this->delete('sw_status', ['id' => 'STARTUP', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Startup', 'sort_order' => 1]);
        $this->delete('sw_status', ['id' => 'VALIDATED', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Validated', 'sort_order' => 2]);
        $this->delete('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'On edit', 'sort_order' => 3]);
        $this->delete('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsWorkflow', 'label' => 'Closed', 'sort_order' => 4]);

        $this->delete('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'STARTUP', 'end_status_id' => 'VALIDATED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'ONEDIT']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'VALIDATED', 'end_status_id' => 'CLOSED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'VALIDATED']);

    }

}
