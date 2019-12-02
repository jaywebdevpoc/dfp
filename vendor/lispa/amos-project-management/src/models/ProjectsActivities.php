<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\core\interfaces\OrganizationsModelInterface;
use lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface;
use lispa\amos\projectmanagement\Module;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class ProjectsActivities
 * This is the model class for table "projects_activities".
 *
 * @property \lispa\amos\core\interfaces\OrganizationsModelInterface[] $projectActivityProjectTasksOrganizations
 *
 * @package lispa\amos\projectmanagement\models
 */
class ProjectsActivities extends \lispa\amos\projectmanagement\models\base\ProjectsActivities implements ItemWorkPlanInterface
{
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
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'duration' => Module::t('amosproject_management', 'Duration'),
        ]);
    }

    /**
     * Get the start date of an activity, considering the first task start date
     * @return mixed|null
     */
    public function getStartDate()
    {
        $firstTask = $this->getProjectsTasks()->orderBy('start_date ASC')->one();
        return $firstTask ? $firstTask->start_date : null;
    }

    /**
     * Get the end date of an activity, considering the last end date of its task
     * @return mixed|null
     */
    public function getEndDate()
    {
        $tasks = $this->getProjectsTasks()->orderBy('start_date DESC')->all();

        if (count($tasks) == 0) {
            return null;
        }

        $lastTaskTime = 0;
        $date = new \DateTime();

        foreach ($tasks as $task) {
            $stringTime = (int)strtotime($task->start_date);
            $endTime = $stringTime + ($task->durationMinutes * 60);

            if ($endTime > $lastTaskTime) {
                $lastTaskTime = $endTime;
            }
        }

        $date->setTimestamp($lastTaskTime);

        return $date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        $tasks = $this->projectsTasks;

        if (count($tasks) == 0) {
            return '-';
        }

        $startTime = strtotime($this->getStartDate());
        $endTime = strtotime($this->getEndDate());
        $durationTime = $endTime - $startTime;

        return \Yii::$app->formatter->asDuration($durationTime);
    }

    /**
     * @return ActiveQuery
     */
    public function getCosts()
    {
        /**
         * @var $query ActiveQuery
         */
        $query = ProjectsTasksCosts::find();
        $query->leftJoin('projects_tasks', 'projects_tasks.id = projects_tasks_costs.projects_tasks_id');
        $query->leftJoin('projects_tasks_projects_activities_mm',
            'projects_tasks_projects_activities_mm.projects_tasks_id = projects_tasks.id');
        $query->leftJoin('projects_activities',
            'projects_activities.id = projects_tasks_projects_activities_mm.projects_activities_id');
        //$query->leftJoin('projects_activities_projects_mm', 'projects_activities_projects_mm.projects_activities_id = projects_activities.id');
        //$query->leftJoin('projects', 'projects.id = projects_activities_projects_mm.projects_id');
        $query->andWhere(['projects_activities.id' => $this->id]);

        return $query;
    }

    /**
     * @param $costItemId
     * @param $organizationId
     * @return array|null|ProjectsTasksCosts
     */
    public function getCostRow($costItemId, $organizationId)
    {
        $query = $this->getCosts();
        $query->select(['SUM(value) valueSumm']);
        $query->andFilterWhere([
            'projects_custom_spending_voices_id' => $costItemId,
            'organization_id' => $organizationId
        ]);
        $result = $query->asArray()->one();

        return $result;
    }

    /**
     * @return OrganizationsModelInterface[]
     */
    public function getProjectActivityProjectTasksOrganizations()
    {
        $tasks = $this->projectsTasks;
        $workPackageOrganizations = [];
        foreach ($tasks as $task) {
            foreach ($task->joinedOrganizations as $organization) {
                $workPackageOrganizations[$organization->id] = $organization;
            }
        }
        return $workPackageOrganizations;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getUserResponsible()
    {
        return strip_tags($this->getAttrUserMm(','));
    }

    /**
     * @inheritdoc
     */
    public function getUserResponsibleId()
    {
        return !empty($this->user) ? $this->user->id : null;
    }

    /**
     * @inheritdoc
     */
    public function getOrganizationResponsible()
    {
        return strip_tags($this->getAttrOrganizationMm(','));
    }

    public function getOrganizationResponsibleId()
    {
        return !empty($this->organization) ? $this->organization->id : null;
    }

    /**
     * @inheritdoc
     */
    public function getClassPath()
    {
        return $this->className();
    }

    /**
     * @inheritdoc
     */
    public function getTypeName()
    {
        return Module::t('amosproject_management', 'WP');
    }

    public function getOrganizationIds()
    {
        $org = $this->getProjectsActivitiesOrganizationMms()->select('organization_id')->column();
        $taskOrg = $this->getTasksOrganizationMms()->select('organization_id')->column();
        $taskOrgJoined = $this->getTasksJoinedOrganizationMms()->select('organization_id')->column();

        $orgIds = ArrayHelper::merge($org, $taskOrg);
        $orgIds = ArrayHelper::merge($orgIds, $taskOrgJoined);
        return $orgIds;
    }
}
