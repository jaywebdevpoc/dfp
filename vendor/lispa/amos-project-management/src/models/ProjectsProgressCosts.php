<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\attachments\behaviors\FileBehavior;
use lispa\amos\comments\models\CommentInterface;
use lispa\amos\core\interfaces\ModelLabelsInterface;
use lispa\amos\core\interfaces\ViewModelInterface;
use lispa\amos\projectmanagement\events\ProjectsProgressCostsWorkflowEvent;
use lispa\amos\projectmanagement\Module;
use lispa\amos\workflow\behaviors\WorkflowLogFunctionsBehavior;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "projects_progress_costs".
 */
class ProjectsProgressCosts extends \lispa\amos\projectmanagement\models\base\ProjectsProgressCosts implements CommentInterface, ModelLabelsInterface, ViewModelInterface
{

    const PROJECTSACTIVITYPROGRESS_WORKFLOW = 'ProjectsActivityProgressWorkflow';
    const PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT = 'ProjectsActivityProgressWorkflow/ONEDIT';
    const PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED = 'ProjectsActivityProgressWorkflow/CONFIRMED';

    public function init()
    {
        if ($this->isNewRecord) {
            $this->status = $this->getWorkflowSource()->getWorkflow(self::PROJECTSACTIVITYPROGRESS_WORKFLOW)->getInitialStatusId();
        }
        $this->on('afterChangeStatusFrom{' . self::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED . '}to{' . self::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT . '}', [new ProjectsProgressCostsWorkflowEvent(), 'afterChangeStatusFromConfirmedToOnEdit'], $this);
        $this->on('afterChangeStatusFrom{' . self::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT . '}to{' . self::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED . '}', [new ProjectsProgressCostsWorkflowEvent(), 'afterChangeStatusFromOnEditToConfirmed'], $this);

        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'workflow' => [
                'class' => SimpleWorkflowBehavior::className(),
                'defaultWorkflowId' => self::PROJECTSACTIVITYPROGRESS_WORKFLOW,
                'propagateErrorsToModel' => true
            ],
            'workflowLogFunctions' => [
                'class' => WorkflowLogFunctionsBehavior::className(),
            ],
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ]
        ]);
    }

    public static function getEditFields()
    {
        $labels = self::attributeLabels();

        return [
            [
                'slug' => 'status',
                'label' => $labels['status'],
                'type' => 'string'
            ],
            [
                'slug' => 'note',
                'label' => $labels['note'],
                'type' => 'text'
            ],
            [
                'slug' => 'projects_progress_cost_type_id',
                'label' => $labels['projects_progress_cost_type_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'projects_progress_detection_period_id',
                'label' => $labels['projects_progress_detection_period_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'projects_task_id',
                'label' => $labels['projects_task_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'user_responsible_id',
                'label' => $labels['user_responsible_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'organization_id',
                'label' => $labels['organization_id'],
                'type' => 'integer'
            ],
        ];
    }

    public function attributeLabels()
    {
        return
            ArrayHelper::merge(
                parent::attributeLabels(),
                [
                ]);
    }

    public function representingColumn()
    {
        return [
            //inserire il campo o i campi rappresentativi del modulo
        ];
    }

    /**
     * Returns the text hint for the specified attribute.
     * @param string $attribute the attribute name
     * @return string the attribute hint
     */
    public function getAttributeHint($attribute)
    {
        $hints = $this->attributeHints();
        return isset($hints[$attribute]) ? $hints[$attribute] : null;
    }

    public function attributeHints()
    {
        return [
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
        ]);
    }

    /**
     * @return string The url to view a single model
     */
    public function getViewUrl()
    {
        return 'project_management/projects-progress-costs/view';
    }

    /**
     * @return string The url to view of this model
     */
    public function getFullViewUrl()
    {
        return Url::toRoute(["/project_management/projects/by-project", "id" => $this->projectsTask->project->id, '#' => 'costs']);
    }

    /**
     * @return mixed
     */
    public function getGrammar()
    {
        return new ProjectsProgressCostsGrammar();
    }

    /**
     * In this method must be defined the conditions that say if the model is commentable and then return true or false.
     * @return bool
     */
    public function isCommentable()
    {
        return true;
    }

    public function getTitle()
    {
        return '';
    }

    public function getDescription()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getWorkflowStatusLabel()
    {
        return Module::t('amosproject_management', parent::getWorkflowStatusLabel());
    }
}
