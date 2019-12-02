<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\core\formatter\Formatter;
use lispa\amos\core\user\User;
use lispa\amos\projectmanagement\Module;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class ProjectsTasks
 *
 * This is the base-model class for table "projects_tasks".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $duration
 * @property string $duration_scale
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $user_responsible_costs_id
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property integer $durationMinutes
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsTasks[] $requiredTasks
 * @property \lispa\amos\projectmanagement\models\ProjectsTasksOrganizationMm[] $ProjectsTasksOrganizationMms
 * @property \lispa\amos\projectmanagement\models\ProjectsTasksTasksMm[] $projectsRequiredTasksMms
 * @property \lispa\amos\projectmanagement\models\ProjectsTasksProjectsActivitiesMm[] $projectsTasksProjectsActivitiesMms
 * @property \lispa\amos\projectmanagement\models\ProjectsTasksProjectsTaskStatusesMm[] $projectsTasksProjectsTaskStatusesMms
 * @property \lispa\amos\projectmanagement\models\ProjectsActivities $projectsActivities
 * @property \lispa\amos\projectmanagement\models\ProjectsProgressStatements $progressStatement
 * @property \lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm[] $projectsActivitiesProjectsMms
 * @property \lispa\amos\projectmanagement\models\Projects $project
 * @property int $publish [int(1)]
 * @property string $status [varchar(255)]
 * @property int $version [int(11)]
 *
 * @package lispa\amos\projectmanagement\models\base
 */
class ProjectsTasks extends \lispa\amos\core\record\Record
{
    const SCENARIO_COSTS_CREATOR = 'costsCreator';

    /**
     * @var array Attributo di relazione
     */
    public $attrProjectsActivitiesMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrOrganizationMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrProjectsTaskStatusesMm;

    /**
     * @var array Attributo di relazione
     */
    public $attrTasksMm;
    public $attrUserMm;
    public $organizationModelClass;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['duration'], 'number', 'min' => 0, 'integerOnly' => true],
            [['publish', 'created_by', 'updated_by', 'deleted_by', 'user_responsible_costs_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['attrProjectsActivitiesMm', 'attrOrganizationMm', 'attrUserMm', 'start_date', 'user_responsible_costs_id'], 'required'],
            [['attrTasksMm', 'attrProjectsActivitiesMm', 'attrOrganizationMm'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        try {
            $this->organizationModelClass = Module::getModuleOrganization()->getOrganizationModelClass();
        } catch (\Exception $e) {
            // DO NOTHING (TO WORK IN CONSOLE WITHOUT ORGANIZATIONS!)
        }
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_COSTS_CREATOR => []
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Module::t('amosproject_management', 'Title'),
            'description' => Module::t('amosproject_management', 'Description'),
            'start_date' => Module::t('amosproject_management', 'Start Date'),
            'end_date' => Module::t('amosproject_management', 'End Date'),
            'duration' => Module::t('amosproject_management', 'Duration'),
            'duration_scale' => Module::t('amosproject_management', 'Duration Scale'),
            'publish' => Module::t('amosproject_management', 'Publish To The Calendar'),
            'user_responsible_costs_id' => Module::t('amosproject_management', 'Cost plan notifier person'),
            'created_at' => Module::t('amosproject_management', 'Creato il'),
            'updated_at' => Module::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Module::t('amosproject_management', 'Cancellato il'),
            'created_by' => Module::t('amosproject_management', 'Creato da'),
            'updated_by' => Module::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Module::t('amosproject_management', 'Cancellato da'),

            'projectsActivities' => Module::t('amosproject_management', 'Activity'),
            'attrProjectsActivitiesMm' => Module::t('amosproject_management', 'Activity'),

            'organization' => Module::t('amosproject_management', 'Reference Organization'),
            'attrOrganizationMm' => Module::t('amosproject_management', 'Reference Organization'),

            'projectsTaskStatuses' => Module::t('amosproject_management', 'Status'),
            'attrProjectsTaskStatusesMm' => Module::t('amosproject_management', 'Status'),

            'tasks' => Module::t('amosproject_management', 'Dependencies'),
            'attrTasksMm' => Module::t('amosproject_management', 'Dependencies'),
            'attrUserMm' => Module::t('amosproject_management', 'Responsible'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasksOrganizationMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksOrganizationMm::className(), ['projects_tasks_id' => 'id'])->inverseOf('projectsTasks');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressStatements()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProgressStatements::className(), ['projects_task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressCosts()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProgressCosts::className(), ['projects_task_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsRequiredTasksMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksTasksMm::className(), ['tasks_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInverseRequiredTasksMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksTasksMm::className(), ['projects_tasks_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasksProjectsActivitiesMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksProjectsActivitiesMm::className(), ['projects_tasks_id' => 'id'])->inverseOf('projectsTasks');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasksProjectsTaskStatusesMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksProjectsTaskStatusesMm::className(), ['projects_tasks_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivities()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsActivities::className(), ['id' => 'projects_activities_id'])->via('projectsTasksProjectsActivitiesMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivitiesProjectsMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm::className(), ['projects_activities_id' => 'projects_activities_id'])->via('projectsTasksProjectsActivitiesMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\Projects::className(), ['id' => 'projects_id'])->via('projectsActivitiesProjectsMms');
    }


    public function getAttrProjectsActivitiesMm()
    {
        $ritorno = "";
        $ritorno .= '' . $this->projectsActivities->name;

        return $ritorno;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne($this->organizationModelClass, ['id' => 'organization_id'])->via('projectsTasksOrganizationMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id'])->via('projectsTasksOrganizationMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResponsibleCosts()
    {
        return $this->hasOne(User::className(), ['id' => 'user_responsible_costs_id']);
    }

    public function getAttrOrganizationMm()
    {
        $ritorno = "";
        $ritorno .= '' . (!is_null($this->organization) ? $this->organization->getNameField() : '');

        return $ritorno;
    }

//    public function getAttrUserMm()
//    {
//        $ritorno = "";
//        $ritorno .= '' . (!is_null($this->user) ? $this->user->userProfile->nomeCognome : '');
//
//        return $ritorno;
//    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTaskStatuses()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsTaskStatuses::className(), ['id' => 'projects_task_statuses_id'])->via('projectsTasksProjectsTaskStatusesMms');
    }

    public function getAttrProjectsTaskStatusesMm()
    {
        $ritorno = "";
        $ritorno .= '' . (!is_null($this->projectsTaskStatuses) ? $this->projectsTaskStatuses->name : '');

        return $ritorno;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequiredTasks()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasks::className(), ['id' => 'projects_tasks_id'])->via('projectsRequiredTasksMms');
    }

    public function getAttrRequiredTasksMm($separator = ' ')
    {
        $ritorno = "";
        $ind = 0;
        foreach ((array)$this->requiredTasks as $str) {
            $ritorno .= (($ind == 0) ? '' : ', ') . $str['name'];
            $ind++;
        }
        return $ritorno;
    }

    public function getDurationMinutes()
    {
        $duration = $this->duration;
        $startTime = strtotime($this->start_date);

        switch ($this->duration_scale) {
            case 'days':
                return $duration * 60 * 24;
                break;
            case 'weeks':
                return $duration * 60 * 24 * 7;
                break;
            //TODO fix monts in months on View/DB/Model/Migrate
            case 'months':
                $oneYearOn = strtotime($this->start_date . " + {$duration} month") - $startTime;
                return $oneYearOn / 60;
                break;
            case 'years':
                $oneYearOn = strtotime($this->start_date . " + {$duration} year") - $startTime;
                return $oneYearOn / 60;
                break;
            default:
                return $duration * 60;
        }
    }

    public function getExpDuration()
    {
        $i18n = new Formatter();

        return $i18n->asDuration($this->durationMinutes * 60);
    }

    public function getUserReferent()
    {
        if (empty($this->user)) {
            return '';
        }
        try {
            return $this->user->userProfile->nomeCognome;
        } catch (\yii\base\Exception $e) {
            return '';
        }
    }

    public function getOrganizationReferentName()
    {
        if (empty($this->organization)) {
            return '';
        }
        try {
            return $this->organization->getNameField();
        } catch (\yii\base\Exception $e) {
            return '';
        }
    }

    /**
     * @return ProjectsProgressStatements
     */
    public function getProgressStatementOnEdit()
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressStatements::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.status' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS,
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::STATEMENTS_TYPE,
            'projects_progress_statements.projects_task_id' => $this->id,
        ]);

        /** @var ProjectsProgressStatements $progressStatement */
        $progressStatement = $query->one();
        return $progressStatement;
    }

    /**
     * @return ProjectsProgressStatements
     */
    public function getProgressStatementOfDetection($idDetection)
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressStatements::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::STATEMENTS_TYPE,
            'projects_progress_statements.projects_task_id' => $this->id,
            'projects_progress_statements.projects_progress_detection_period_id' => $idDetection,
        ]);

        /** @var ProjectsProgressStatements $progressStatement */
        $progressStatement = $query->one();
        return $progressStatement;
    }

    /**
     * @return ProjectsProgressCosts
     */
    public function getProgressCostOnEdit()
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressCosts::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.status' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_INPROGRESS,
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::COSTS_TYPE,
            'projects_progress_costs.projects_task_id' => $this->id,
        ]);

        /** @var ProjectsProgressCosts $progressCost */
        $progressCost = $query->one();
        return $progressCost;
    }

    public function getProgressCostOfDetection($idDetection)
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressCosts::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::COSTS_TYPE,
            'projects_progress_costs.projects_task_id' => $this->id,
            'projects_progress_costs.projects_progress_detection_period_id' => $idDetection,
        ]);

        /** @var ProjectsProgressCosts $progressCost */
        $progressCost = $query->one();
        return $progressCost;
    }

    /**
     * The actual progress statement
     *
     * @return ProjectsProgressStatements
     */
    public function getProgressStatement()
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressStatements::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::STATEMENTS_TYPE,
            'projects_progress_statements.projects_task_id' => $this->id,
        ]);

        /** @var ProjectsProgressStatements $progressStatement */
        $progressStatement = $query->one();
        return $progressStatement;
    }

    /**
     * The actual progress cost
     *
     * @return ProjectsProgressCosts
     */
    public function getProgressCost()
    {
        $projects = $this->projectsActivities->projects;
        /** @var ActiveQuery $query */
        $query = \lispa\amos\projectmanagement\models\ProjectsProgressCosts::find();
        $query->joinWith('projectsProgressDetectionPeriod');

        $query->andWhere([
            'projects_progress_detection_period.projects_id' => $projects->id,
            'projects_progress_detection_period.projects_progress_detection_type_id' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::COSTS_TYPE,
            'projects_progress_costs.projects_task_id' => $this->id,
        ]);

        /** @var ProjectsProgressCosts $progressStatement */
        $progressStatement = $query->one();

        return $progressStatement;
    }


//    public function getattrUserMm()
//    {
//        $ritorno = "";
//        if ($this->user) {
//            $ritorno .= '' . $this->user->userProfile->nomeCognome;
//        }
//
//        return $ritorno;
//    }

    /**  //TODO check to remove
     * public function beforeSave($insert)
     * {
     * //Old version
     * $curr = self::findOne($this->id);
     *
     * //Get times
     * $startTime = strtotime($this->start_date);
     * $endTime = strtotime($this->end_date);
     *
     * if ($curr) {
     * if ($curr->end_date != $this->end_date) {
     * //Days
     * $dayStart = date('d', $startTime);
     * $dayEnd = date('d', $endTime);
     *
     * //Months
     * $monthStart = date('m', $startTime);
     * $monthEnd = date('m', $endTime);
     *
     * //Years
     * $yearStart = date('Y', $startTime);
     * $yearEnd = date('Y', $endTime);
     *
     * $durationDays = ($endTime - $startTime) / 60 / 60 / 24;
     *
     * if ($dayStart == $dayEnd && $monthStart == $monthEnd && $yearStart != $yearEnd) {
     * //Minimum measure
     * $this->duration_scale = 'years';
     *
     * //Set new minutes
     * $this->duration = $yearEnd - $yearStart;
     * } elseif ($dayStart == $dayEnd && $monthStart != $monthEnd && $yearStart == $yearEnd) {
     * //Minimum measure
     * $this->duration_scale = 'months';
     *
     * //Set new minutes
     * $this->duration = $monthEnd - $monthStart;
     * } else {
     * //Minimum measure
     * $this->duration_scale = 'days';
     *
     * //Set new minutes
     * $this->duration = $durationDays;
     * }
     * } elseif ($curr->duration != $this->duration || $curr->duration_scale != $this->duration_scale) {
     * // Minutes added to end date
     * $durationMinutes = self::getDurationMinutes() * 60;
     *
     * //New date from duration minutes
     * $newDate = date('Y-m-d', $startTime + $durationMinutes);
     *
     * //Set date
     * $this->end_date = $newDate;
     * }
     * }
     *
     * $this->duration = $this->duration < 0 ? 0 : $this->duration;
     *
     * return parent::beforeSave($insert);
     * }*/
}
