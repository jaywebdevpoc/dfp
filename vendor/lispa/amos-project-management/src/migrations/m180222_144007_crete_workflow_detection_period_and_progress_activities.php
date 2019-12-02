<?php

use yii\db\Migration;

/**
 * Class m180222_144007_crete_workflow_detection_period_and_progress_activities
 */
class m180222_144007_crete_workflow_detection_period_and_progress_activities extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {

        $this->insert('sw_workflow', ['id' => 'ProjectsDetectionPeriodWorkflow', 'initial_status_id' => 'PLANNED']);

        $this->insert('sw_status', ['id' => 'PLANNED', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'Planned', 'sort_order' => 1]);
        $this->insert('sw_status', ['id' => 'INPROGRESS', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'In progress', 'sort_order' => 2]);
        $this->insert('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'Closed', 'sort_order' => 3]);

        $this->insert('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'PLANNED', 'end_status_id' => 'INPROGRESS']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'INPROGRESS', 'end_status_id' => 'CLOSED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'CLOSED', 'end_status_id' => 'INPROGRESS']);


        $this->insert('sw_workflow', ['id' => 'ProjectsActivityProgressWorkflow', 'initial_status_id' => 'ONEDIT']);

        $this->insert('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsActivityProgressWorkflow', 'label' => 'On edit', 'sort_order' => 1]);
        $this->insert('sw_status', ['id' => 'CONFIRMED', 'workflow_id' => 'ProjectsActivityProgressWorkflow', 'label' => 'Confirmed', 'sort_order' => 2]);

        $this->insert('sw_transition', ['workflow_id' => 'ProjectsActivityProgressWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'CONFIRMED']);
        $this->insert('sw_transition', ['workflow_id' => 'ProjectsActivityProgressWorkflow','start_status_id' => 'CONFIRMED', 'end_status_id' => 'ONEDIT']);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_workflow', ['id' => 'ProjectsDetectionPeriodWorkflow', 'initial_status_id' => 'PLANNED']);

        $this->delete('sw_status', ['id' => 'PLANNED', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'Planned', 'sort_order' => 1]);
        $this->delete('sw_status', ['id' => 'INPROGRESS', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'In progress', 'sort_order' => 2]);
        $this->delete('sw_status', ['id' => 'CLOSED', 'workflow_id' => 'ProjectsDetectionPeriodWorkflow', 'label' => 'Closed', 'sort_order' => 3]);

        $this->delete('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'PLANNED', 'end_status_id' => 'INPROGRESS']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'INPROGRESS', 'end_status_id' => 'CLOSED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsDetectionPeriodWorkflow','start_status_id' => 'CLOSED', 'end_status_id' => 'INPROGRESS']);


        $this->delete('sw_workflow', ['id' => 'ProjectsActivityProgressWorkflow', 'initial_status_id' => 'ONEDIT']);

        $this->delete('sw_status', ['id' => 'ONEDIT', 'workflow_id' => 'ProjectsActivityProgressWorkflow', 'label' => 'On edit', 'sort_order' => 1]);
        $this->delete('sw_status', ['id' => 'CONFIRMED', 'workflow_id' => 'ProjectsActivityProgressWorkflow', 'label' => 'Confirmed', 'sort_order' => 2]);

        $this->delete('sw_transition', ['workflow_id' => 'ProjectsActivityProgressWorkflow','start_status_id' => 'ONEDIT', 'end_status_id' => 'CONFIRMED']);
        $this->delete('sw_transition', ['workflow_id' => 'ProjectsActivityProgressWorkflow','start_status_id' => 'CONFIRMED', 'end_status_id' => 'ONEDIT']);

    }

}
