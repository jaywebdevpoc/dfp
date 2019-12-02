<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;

class m180316_143234_add_metadata_workflow_detection_periods extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'PLANNED', 'key' => 'label', 'value' => 'Planned']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'PLANNED', 'key' => 'buttonLabel', 'value' => 'Planned']);

        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'INPROGRESS', 'key' => 'label', 'value' => 'In progress']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'INPROGRESS', 'key' => 'buttonLabel', 'value' => 'In progress']);

        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'label', 'value' => 'Closed']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'buttonLabel', 'value' => 'Closed']);


        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'label', 'value' => 'On edit']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'buttonLabel', 'value' => 'On edit']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW, 'status_id' => 'CONFIRMED', 'key' => 'label', 'value' => 'Confirmed']);
        $this->insert('sw_metadata', ['workflow_id' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW, 'status_id' => 'CONFIRMED', 'key' => 'buttonLabel', 'value' => 'Confirmed']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_metadata', ['workflow_id' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW]);
        $this->delete('sw_metadata', ['workflow_id' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW]);
    }
}
