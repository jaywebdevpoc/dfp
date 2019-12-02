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
 * Class m180531_074143_add_pm_modify_request_metadata
 */
class m180531_074143_add_pm_modify_request_metadata extends AmosMigrationWorkflow
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
                'status_id' => 'TOVALIDATE',
                'key' => 'message',
                'value' => "Confermi l'invio della richiesta di modifica?"
            ]
        ];
    }
}
