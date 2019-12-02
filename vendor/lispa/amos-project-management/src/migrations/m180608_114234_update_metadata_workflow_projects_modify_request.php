<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;

class m180608_114234_update_metadata_workflow_projects_modify_request extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->update('sw_metadata', [ 'value' => "#accept_modification"], ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'buttonLabel']);
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'order', 'value' => "1"]);
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'TOVALIDATE', 'key' => 'order', 'value' => "2"]);
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'REJECTED', 'key' => 'order', 'value' => "3"]);
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'order', 'value' => "4"]);
        $this->insert('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'order', 'value' => "5"]);
    }


    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->update('sw_metadata', [ 'value' => "Valida"], ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'buttonLabel']);
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'ONEDIT', 'key' => 'order', 'value' => "1"]);
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'TOVALIDATE', 'key' => 'order', 'value' => "2"]);
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'REJECTED', 'key' => 'order', 'value' => "3"]);
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'VALIDATED', 'key' => 'order', 'value' => "4"]);
        $this->delete('sw_metadata', ['workflow_id' => \lispa\amos\projectmanagement\models\ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW, 'status_id' => 'CLOSED', 'key' => 'order', 'value' => "5"]);
    }
}
