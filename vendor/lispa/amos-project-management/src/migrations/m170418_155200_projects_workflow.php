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
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class m170418_155200_projects_workflow
 */
class m170418_155200_projects_workflow extends AmosMigrationWorkflow
{
    const PROJECTS_WORKFLOW_NAME = 'ProjectsWorkflow';

    /**
     * @var string $migrationTable
     */
    private $migrationTable = '{{%migration}}';

    /**
     * @var string $oldMigrationName
     */
    private $oldMigrationName = 'm170418_155100_projects_workflow';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $query = new Query();
        $query->from($this->migrationTable);
        $query->andWhere(['like', 'version', $this->oldMigrationName]);
        $exists = $query->exists();
        if ($exists) {
            $this->delete($this->migrationTable, ['version' => $this->oldMigrationName]);
            return true;
        } else {
            return parent::safeUp();
        }
    }

    /**
     * @inheritdoc
     */
    protected function setWorkflow()
    {
        return ArrayHelper::merge(
            parent::setWorkflow(),
            $this->workflowConf(),
            $this->workflowStatusConf(),
            $this->workflowTransitionsConf(),
            $this->workflowMetadataConf()
        );
    }

    /**
     * In this method there are the new workflow configuration.
     * @return array
     */
    private function workflowConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW,
                'id' => self::PROJECTS_WORKFLOW_NAME,
                'initial_status_id' => 'DRAFT'
            ]
        ];
    }

    /**
     * In this method there are the new workflow statuses configurations.
     * @return array
     */
    private function workflowStatusConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'DRAFT',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Draft',
                'sort_order' => '0'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'PUBLISHREQUEST',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Publish request',
                'sort_order' => '1'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'PUBLISHED',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Published',
                'sort_order' => '2'
            ]
        ];
    }

    /**
     * In this method there are the new workflow status transitions configurations.
     * @return array
     */
    private function workflowTransitionsConf()
    {
        return [
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'DRAFT',
                'end_status_id' => 'PUBLISHREQUEST'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHREQUEST',
                'end_status_id' => 'PUBLISHED'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'DRAFT',
                'end_status_id' => 'PUBLISHED'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHED',
                'end_status_id' => 'DRAFT'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'PUBLISHREQUEST',
                'end_status_id' => 'DRAFT'
            ]
        ];
    }

    /**
     * In this method there are the new workflow metadata configurations.
     * @return array
     */
    private function workflowMetadataConf()
    {
        return [
            // "Draft" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'description',
                'value' => 'Project editing'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'DRAFT',
                'key' => 'label',
                'value' => 'Updating'
            ],

            // "Publish request" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'description',
                'value' => 'It puts a project in publish request'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'label',
                'value' => 'Publish request'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHREQUEST',
                'key' => 'message',
                'value' => 'Do you want to set the publish request status?'
            ],

            // "Published" status
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'class',
                'value' => 'btn btn-navigation-primary'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'description',
                'value' => 'The project management will be published'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'label',
                'value' => 'Published'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'message',
                'value' => 'Do you want to publish the project?'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'PUBLISHED',
                'key' => 'order',
                'value' => '1'
            ]
        ];
    }
}
