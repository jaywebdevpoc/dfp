<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;

/**
 * Class m180219_141956_create_metadata_button_label_projects
 */
class m180219_141956_create_metadata_button_label_projects extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->delete('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW]);

        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'STARTUP', 'key' => 'label', 'value' => 'Startup']);
        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'label', 'value' => 'Validated']);
        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'label', 'value' => 'On edit']);
        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'label', 'value' => 'Closed']);

        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'buttonLabel', 'value' => 'Validated']);
        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'buttonLabel', 'value' => 'On edit']);
        $this->insert('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'buttonLabel', 'value' => 'Closed']);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('sw_metadata', ['workflow_id' => Projects::PROJECTS_WORKFLOW]);
    }

}
