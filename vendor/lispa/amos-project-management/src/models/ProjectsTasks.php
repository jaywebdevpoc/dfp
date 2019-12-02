<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\attachments\behaviors\FileBehavior;
use lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface;
use lispa\amos\projectmanagement\Module;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class ProjectsTasks
 *
 * This is the model class for table "projects_tasks".
 * @property string $endDate
 * @property string $duration_scale
 * @property string $organizations
 * @property integer $startTime
 * @property integer $endTime
 * @property bool $hasDependencyError
 *
 * @property \lispa\amos\core\interfaces\OrganizationsModelInterface[] $joinedOrganizations
 *
 * @package lispa\amos\projectmanagement\models
 */
class ProjectsTasks extends \lispa\amos\projectmanagement\models\base\ProjectsTasks implements ItemWorkPlanInterface
{
    public $start_date_from;
    public $start_date_to;

    public $tasksAttachments;
    public $tasksAttachmentsForItemView;

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->tasksAttachments = $this->getTasksAttachments()->one();
        $this->tasksAttachmentsForItemView = $this->getTasksAttachments()->all();
    }

    /**
     * Getter for $this->tasksAttachments;
     * @return \yii\db\ActiveQuery
     */
    public function getTasksAttachments()
    {
        return $this->hasMultipleFiles('tasksAttachments');
    }

    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'name',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['tasksAttachments'], 'file', 'maxFiles' => 0],
            [['start_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
            [['duration_scale'], 'string'],
            ['end_date', 'validateDates'],
            [['duration'], 'required', 'skipOnError' => true],
        ]);
    }

    /**
     * @param string $attribute
     * @param array $params
     */
    public function validateDates($attribute, $params)
    {
        // case 1
        if (strtotime($this->end_date) < strtotime($this->start_date)) {
            $this->addError('start_date', Module::t('amosproject_management', 'Start date must be set before finish date'));
            $this->addError('end_date', Module::t('amosproject_management', 'Finish date must be set after start date'));
            return;
        }

        try {
            // check if the date is after start project
            /** @var Projects $project */
            if (!empty($this->projectsActivities)) {
                $project = $this->projectsActivities->projects;
            } else {
                $activity = ProjectsActivities::findOne(\Yii::$app->request->get('activity_id'));
                $project = $activity->projects;
            }
            if (!empty($project->start_date)) {
                if (strtotime($this->start_date) < strtotime($project->start_date)) {
                    $this->addError('start_date', Module::t('amosproject_management', 'Start date must be set after project start date'));
                    return;
                }
            }
        } catch (\Exception $e) {
            $this->addError('start_date', $e->getMessage() . ' L: ' . $e->getLine());
            return;
        }

        try {
            // check if the date is after start project
            /** @var Projects $project */
            if (!empty($this->projectsActivities)) {
                $project = $this->projectsActivities->projects;
            } else {
                $activity = ProjectsActivities::findOne(\Yii::$app->request->get('activity_id'));
                $project = $activity->projects;
            }
            if (!empty($project->finish_date)) {
                if (strtotime($this->end_date) > strtotime($project->finish_date)) {
                    $this->addError('end_date', Module::t('amosproject_management', 'End date must be set before project end date'));
                    \Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Elemento non aggiornato, verificare i dati inseriti.'));
                    return;
                }
            }
        } catch (\Exception $e) {
            $this->addError('end_date', $e->getMessage());
            return;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'start_date_from' => 'Da start_date',
                'start_date_to' => 'A  start_date',
                'endDate' => Module::t('amosproject_management', 'End Date'),
                'expDuration' => Module::t('amosproject_management', 'Expected Duration'),
                'dependencyStatus' => false,
            ]
        );
    }

    public function getEndDate()
    {
        $date = new \DateTime();
        $stringTime = (int)strtotime($this->start_date);

        $date->setTimestamp($stringTime + ($this->durationMinutes * 60));

        return $date->format('Y-m-d');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasksJoinedOrganizationsMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksJoinedOrganizationsMm::className(), ['projects_tasks_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJoinedOrganizations()
    {
        $className = Module::getModuleOrganization()->getOrganizationModelClass();
        return $this->hasMany($className::className(), ['id' => 'organization_id'])->via('projectsTasksJoinedOrganizationsMms');
    }

    public function getattrJoinedOrganizationsMm($separator = ' ')
    {
        $ritorno = "";
        $ind = 0;
        foreach ((array)$this->joinedOrganizations as $str) {
            $ritorno .= (($ind == 0) ? '' : ', ') . $str['name'];
            $ind++;
        }
        return $ritorno;
    }

    /**
     * @return \lispa\amos\projectmanagement\models\base\ProjectsCustomSpendingVoices[]
     */
    public function getCostItems()
    {
        return $this->projectsActivities->projects->getProjectsSpendingVoices();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectJoinedOrganizations()
    {
        return $this->projectsActivities->projects->getJoinedOrganizations();
    }

    /**
     * @param int $costItemId
     * @param int $organizationId
     * @return ProjectsTasksCosts
     */
    public function getCostRow($costItemId, $organizationId)
    {
        $query = $this->getCosts()->andFilterWhere([
            'projects_custom_spending_voices_id' => $costItemId,
            'organization_id' => $organizationId
        ]);
        /** @var ProjectsTasksCosts $result */
        $result = $query->one();
        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getCosts()
    {
        return $this->hasMany(ProjectsTasksCosts::className(), ['projects_tasks_id' => 'id']);
    }

    /**
     * Expected array is like this
     * Array
     *   (
     *       [1] => Array //Organization ID
     *       (
     *           [5] => 12.67 //Cost Item ID => Value
     *           [6] => 0 //Cost Item ID => Value
     *           [7] => 0 //Cost Item ID => Value
     *           [8] => 0 //Cost Item ID => Value
     *           [9] => 0 //Cost Item ID => Value
     *           [10] => 0 //Cost Item ID => Value
     *       )
     *       [2] => Array //Organization ID
     *       (
     *           [5] => 0 //Cost Item ID => Value
     *           [6] => 189 //Cost Item ID => Value
     *           [7] => 0 //Cost Item ID => Value
     *           [8] => 0 //Cost Item ID => Value
     *           [9] => 0 //Cost Item ID => Value
     *           [10] => 0 //Cost Item ID => Value
     *       )
     *   )
     *
     * @param $dataArray
     * @return bool
     * @throws Exception
     */
    public function storeNewCosts($dataArray)
    {
        if (empty($dataArray)) {
            return false;
        }

        //Drop current costs
        ProjectsTasksCosts::deleteAll(['projects_tasks_id' => $this->id]);

        foreach ($dataArray as $organizationId => $costItems) {
            foreach ($costItems as $costItemId => $value) {
                $projectsTasksCost = new ProjectsTasksCosts();
                $projectsTasksCost->organization_id = $organizationId;
                $projectsTasksCost->projects_custom_spending_voices_id = $costItemId;
                $projectsTasksCost->projects_tasks_id = $this->id;
                $projectsTasksCost->value = (float)$value;
                $projectsTasksCost->save();
            }
        }

        return true;
    }

    /**
     * @return false|int
     */
    public function getStartTime()
    {
        return strtotime($this->start_date);
    }

    /**
     * @return false|int
     */
    public function getEndTime()
    {
        return strtotime($this->end_date);
    }

    /**
     * @return bool|int
     */
    public function getHasDependencyError($inverse = false)
    {
        foreach ($this->projectsRequiredTasksMms as $requiredTask) {
            if ($error = $requiredTask->hasDependencyError($inverse)) {
                return $error;
            }
        }

        return false;
    }

    /**
     * @return ProjectsTasks|null
     */
    public function getFirstDependencyTaskError($inverse = false)
    {
        foreach ($this->projectsRequiredTasksMms as $requiredTask) {
            if ($error = $requiredTask->hasDependencyError($inverse)) {
                return $requiredTask->requiredTasks;
            }
        }

        return null;
    }


    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUserResponsible()
    {
        return $this->userReferent;
    }

    public function getUserResponsibleId()
    {
        return $this->user->id;
    }

    public function getOrganizationResponsible()
    {
        return $this->referentOrg;
    }

    public function getOrganizationResponsibleId()
    {
        return empty($this->organization) ? null : $this->organization->id;
    }

    public function getClassPath()
    {
        return $this->className();
    }

    public function getTypeName()
    {
        return Module::t('amosproject_management', 'Activity');
    }

}
