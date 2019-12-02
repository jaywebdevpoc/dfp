<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\projectmanagement\Module;
use lispa\amos\workflow\behaviors\WorkflowLogFunctionsBehavior;
use raoul2000\workflow\base\SimpleWorkflowBehavior;
use raoul2000\workflow\base\Workflow;
use raoul2000\workflow\helpers\WorkflowHelper;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects_progress_detection_period".
 */
class ProjectsProgressDetectionPeriod extends \lispa\amos\projectmanagement\models\base\ProjectsProgressDetectionPeriod
{

    const PROJECTSDETECTIONPERIOD_WORKFLOW = 'ProjectsDetectionPeriodWorkflow';
    const PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED = 'ProjectsDetectionPeriodWorkflow/PLANNED';
    const PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS = 'ProjectsDetectionPeriodWorkflow/INPROGRESS';
    const PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_CLOSED = 'ProjectsDetectionPeriodWorkflow/CLOSED';

    const STATEMENTS_TYPE = 1;
    const COSTS_TYPE = 2;

    public $start_date_from;
    public $start_date_to;
    public $end_date_from;
    public $end_date_to;

    public function init()
    {
        if ($this->isNewRecord) {
            $this->status = $this->getWorkflowSource()->getWorkflow(self::PROJECTSDETECTIONPERIOD_WORKFLOW)->getInitialStatusId();
        }

        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'workflow' => [
                'class' => SimpleWorkflowBehavior::className(),
                'defaultWorkflowId' => self::PROJECTSDETECTIONPERIOD_WORKFLOW,
                'propagateErrorsToModel' => true
            ],
            'workflowLogFunctions' => [
                'class' => WorkflowLogFunctionsBehavior::className(),
            ],
//            'fileBehavior' => [
//                'class' => FileBehavior::className()
//            ]
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
                'slug' => 'warning_date',
                'label' => $labels['warning_date'],
                'type' => 'datetime'
            ],
            [
                'slug' => 'start_date',
                'label' => $labels['start_date'],
                'type' => 'date'
            ],
            [
                'slug' => 'end_date',
                'label' => $labels['end_date'],
                'type' => 'date'
            ],
//            [
//                'slug' => 'percentage_completition',
//                'label' => $labels['percentage_completition'],
//                'type' => 'integer'
//            ],
            [
                'slug' => 'projects_progress_detection_type_id',
                'label' => $labels['projects_progress_detection_type_id'],
                'type' => 'integer'
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
                    'start_date_from' => 'Da start_date',
                    'start_date_to' => 'A  start_date',
                    'end_date_from' => 'Da end_date',
                    'end_date_to' => 'A  end_date',
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

    public function getPercentageCompletition()
    {
        $query1 = null;
        if ($this->projects_progress_detection_type_id == self::STATEMENTS_TYPE) {
            $query1 = $this->getProjectsProgressStatements();
        }
        if ($this->projects_progress_detection_type_id == self::COSTS_TYPE) {
            $query1 = $this->getProjectsProgressCosts();
        }
        if (is_null($query1)){
            return 0.0;
        }

        $query2 = clone $query1;

        $total = count($query1->all());
        $confirmed = count($query2->andWhere(['status' => ProjectsProgressStatements::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_CONFIRMED])->all());
        if ($total == 0) return 0.0;
        return bcdiv(bcmul($confirmed, 100,2),$total,2);

    }

    public function getPercentageCompletitionString()
    {

        return $this->getPercentageCompletition() . '%';

    }

    /**
     * @inheritdoc
     */
    public function getWorkflowStatusLabel()
    {
        return Module::t('amosproject_management', parent::getWorkflowStatusLabel());
    }

    /**
     * @return array
     */
    public function getListOfStatusForFieds()
    {
        $list = WorkflowHelper::getAllStatusListData(ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW, $this->getWorkflowSource());
        foreach ($list as $key => $value){
            $list[$key] =  Module::t('amosproject_management', $value);
        }
        return $list;
    }


}
