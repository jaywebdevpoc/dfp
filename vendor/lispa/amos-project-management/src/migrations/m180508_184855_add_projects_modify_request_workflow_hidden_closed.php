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

/**
 * Class m180508_184855_add_projects_modify_request_workflow_hidden_closed
 */
class m180508_184855_add_projects_modify_request_workflow_hidden_closed extends AmosMigrationWorkflow
{
    const WORKFLOW_NAME = 'ProjectsModifyRequestWorkflow';

    /**
     * @inheritdoc
     */
    protected function setWorkflow()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::WORKFLOW_NAME,
                'status_id' => 'CLOSED',
                'key' => 'hidden',
                'value' => 'true'
            ]
        ];
    }
}
