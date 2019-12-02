<?php
use yii\helpers\ArrayHelper;
use lispa\amos\core\migration\AmosMigrationWorkflow;


class m180314_142401_crete_new_project_wizard_workflow extends AmosMigrationWorkflow
{
    const PROJECTS_WORKFLOW_NAME = 'NewProjectWizardWorkflow';

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
                'initial_status_id' => 'STEPA'
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
                'id' => 'STEPA',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Step A',
                'sort_order' => '0'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'STEPB',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Step B',
                'sort_order' => '1'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'STEPC',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Step C',
                'sort_order' => '1'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_STATUS,
                'id' => 'STEPD',
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'label' => 'Step D',
                'sort_order' => '1'
            ],
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
                'start_status_id' => 'STEPA',
                'end_status_id' => 'STEPB'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'STEPA',
                'end_status_id' => 'STEPC'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'STEPB',
                'end_status_id' => 'STEPC'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'STEPB',
                'end_status_id' => 'STEPD'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_TRANSITION,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'start_status_id' => 'STEPC',
                'end_status_id' => 'STEPD'
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
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPA',
                'key' => 'model',
                'value' => 'lispa\amos\projectmanagement\models\new_project_wizard\StepA'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPA',
                'key' => 'view',
                'value' => 'step_a'
            ],

            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPB',
                'key' => 'model',
                'value' => 'lispa\amos\projectmanagement\models\new_project_wizard\StepB'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPB',
                'key' => 'view',
                'value' => 'step_b'
            ],

            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPC',
                'key' => 'model',
                'value' => 'lispa\amos\projectmanagement\models\new_project_wizard\StepC'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPC',
                'key' => 'view',
                'value' => 'step_c'
            ],

            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPD',
                'key' => 'model',
                'value' => 'lispa\amos\projectmanagement\models\new_project_wizard\StepD'
            ],
            [
                'type' => AmosMigrationWorkflow::TYPE_WORKFLOW_METADATA,
                'workflow_id' => self::PROJECTS_WORKFLOW_NAME,
                'status_id' => 'STEPD',
                'key' => 'view',
                'value' => 'step_d'
            ],

        ];
    }
}