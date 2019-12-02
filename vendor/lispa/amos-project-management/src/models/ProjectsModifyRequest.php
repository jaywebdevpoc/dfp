<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\attachments\behaviors\FileBehavior;
use lispa\amos\comments\models\CommentInterface;
use lispa\amos\core\interfaces\ModelLabelsInterface;
use lispa\amos\core\interfaces\ViewModelInterface;
use lispa\amos\projectmanagement\events\ProjectsModifyRequestsWorkflowEvent;
use lispa\amos\projectmanagement\Module;
use lispa\amos\workflow\behaviors\WorkflowLogFunctionsBehavior;
use lispa\amos\workflow\models\WorkflowTransitionsLog;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "projects_modify_request".
 */
class ProjectsModifyRequest extends \lispa\amos\projectmanagement\models\base\ProjectsModifyRequest implements CommentInterface, ModelLabelsInterface, ViewModelInterface
{

    const PROJECTSMODIFYREQUEST_WORKFLOW = 'ProjectsModifyRequestWorkflow';
    const PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT = 'ProjectsModifyRequestWorkflow/ONEDIT';
    const PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE = 'ProjectsModifyRequestWorkflow/TOVALIDATE';
    const PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED = 'ProjectsModifyRequestWorkflow/VALIDATED';
    const PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED = 'ProjectsModifyRequestWorkflow/REJECTED';
    const PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_CLOSED = 'ProjectsModifyRequestWorkflow/CLOSED';

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
                'slug' => 'description',
                'label' => $labels['description'],
                'type' => 'text'
            ],
            [
                'slug' => 'projects_id',
                'label' => $labels['projects_id'],
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

    public function init()
    {
        if ($this->isNewRecord) {
            $this->status = $this->getWorkflowSource()->getWorkflow(self::PROJECTSMODIFYREQUEST_WORKFLOW)->getInitialStatusId();
        }

        $this->on('afterEnterStatus{' . self::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED . '}', [new ProjectsModifyRequestsWorkflowEvent(), 'afterEnterStatusValidated'], $this);
        $this->on('afterEnterStatus{' . self::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE . '}', [new ProjectsModifyRequestsWorkflowEvent(), 'afterEnterStatusToValidate'], $this);
        $this->on('afterEnterStatus{' . self::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED . '}', [new ProjectsModifyRequestsWorkflowEvent(), 'afterEnterStatusRejected'], $this);

        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'workflow' => [
                'class' => SimpleWorkflowBehavior::className(),
                'defaultWorkflowId' => self::PROJECTSMODIFYREQUEST_WORKFLOW,
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
     * @return null|string
     */
    public function getFirstSendToValidate()
    {
        /** @var WorkflowTransitionsLog $log */
        foreach ($this->getStatusUpdateHistory() as $log) {
            if ($log->end_status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE) {
                return $log->created_at;
            }
        }
        return null;
    }

    /**
     * In this method must be defined the conditions that say if the model is commentable and then return true or false.
     * @return bool
     */
    public function isCommentable()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function getGrammar()
    {
        return new ProjectsModifyRequestGrammar();
    }

    /**
     * @return string The url to view a single model
     */
    public function getViewUrl()
    {
        return 'project_management/projects-modify-request/update';
    }

    /**
     * @return string The url to view of this model
     */
    public function getFullViewUrl()
    {
        return Url::toRoute(["/" . $this->getViewUrl(), "id" => $this->id]);
    }

    /**
     * @return string The url to view of this model
     */
    public function getTitle()
    {
        return $this->projects->name;
    }

    /**
     * @return string The url to view of this model
     */
    public function getDescription()
    {
        return $this->projects->insights;
    }

    /**
     * @inheritdoc
     */
    public function getWorkflowStatusLabel()
    {
        return Module::t('amosproject_management', parent::getWorkflowStatusLabel());
    }
}
