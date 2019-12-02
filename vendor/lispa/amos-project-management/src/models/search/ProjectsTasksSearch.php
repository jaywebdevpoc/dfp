<?php

namespace lispa\amos\projectmanagement\models\search;

use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksOrganizationMmQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProjectsTasksSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsTasks`.
 */
class ProjectsTasksSearch extends ProjectsTasks
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'description', 'start_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['duration'], 'number'],
            [
                [
                    'start_date_from',
                    'start_date_to',
                ],
                'safe'
            ],
            ['attrProjectsActivitiesMm', 'safe'],
            ['attrOrganizationMm', 'safe'],
            ['attrProjectsTaskStatusesMm', 'safe'],
            ['attrTasksMm', 'safe'],
        ];
    }

    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectsTasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('projectsActivities');
        $query->joinWith('organization');
        $query->joinWith('projectsTaskStatuses');
        //$query->joinWith('requiredTasks rt');

        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['projects_tasks.name' => SORT_ASC],
                    'desc' => ['projects_tasks.name' => SORT_DESC],
                ],
                'description' => [
                    'asc' => ['projects_tasks.description' => SORT_ASC],
                    'desc' => ['projects_tasks.description' => SORT_DESC],
                ],
                'start_date' => [
                    'asc' => ['projects_tasks.start_date' => SORT_ASC],
                    'desc' => ['projects_tasks.start_date' => SORT_DESC],
                ],
                'duration' => [
                    'asc' => ['projects_tasks.duration' => SORT_ASC],
                    'desc' => ['projects_tasks.duration' => SORT_DESC],
                ],
                'projectsActivities' => [
                    'asc' => ['projects_activities.name' => SORT_ASC],
                    'desc' => ['projects_activities.name' => SORT_DESC],
                ],
                'organization' => [
                    'asc' => ['organization.name' => SORT_ASC],
                    'desc' => ['organization.name' => SORT_DESC],
                ],
                'projectsTaskStatuses' => [
                    'asc' => ['projects_task_statuses.name' => SORT_ASC],
                    'desc' => ['projects_task_statuses.name' => SORT_DESC],
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['>=', 'start_date', $this->start_date_from]);
        $query->andFilterWhere(['<=', 'start_date', $this->start_date_to]);
        $query->andFilterWhere([
            'like',
            new \yii\db\Expression('projects_activities.name'),
            $this->attrProjectsActivitiesMm
        ]);
        $query->andFilterWhere(['like', new \yii\db\Expression('organization.name'), $this->attrOrganizationMm]);
        $query->andFilterWhere([
            'like',
            new \yii\db\Expression('projects_task_statuses.name'),
            $this->attrProjectsTaskStatusesMm
        ]);
        $query->andFilterWhere(['like', new \yii\db\Expression('tasks.name'), $this->attrTasksMm]);

        return $dataProvider;
    }

    /**
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    private function baseListsSearch($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('projectsActivities');
        $query->joinWith('organization');
        $query->joinWith('projectsTaskStatuses');

        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['projects_tasks.name' => SORT_ASC],
                    'desc' => ['projects_tasks.name' => SORT_DESC],
                ],
                'description' => [
                    'asc' => ['projects_tasks.description' => SORT_ASC],
                    'desc' => ['projects_tasks.description' => SORT_DESC],
                ],
                'start_date' => [
                    'asc' => ['projects_tasks.start_date' => SORT_ASC],
                    'desc' => ['projects_tasks.start_date' => SORT_DESC],
                ],
                'duration' => [
                    'asc' => ['projects_tasks.duration' => SORT_ASC],
                    'desc' => ['projects_tasks.duration' => SORT_DESC],
                ],
                'projectsActivities' => [
                    'asc' => ['projects_activities.name' => SORT_ASC],
                    'desc' => ['projects_activities.name' => SORT_DESC],
                ],
                'organization' => [
                    'asc' => ['organization.name' => SORT_ASC],
                    'desc' => ['organization.name' => SORT_DESC],
                ],
                'projectsTaskStatuses' => [
                    'asc' => ['projects_task_statuses.name' => SORT_ASC],
                    'desc' => ['projects_task_statuses.name' => SORT_DESC],
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])->andFilterWhere([
            'like',
            'description',
            $this->description
        ]);
        $query->andFilterWhere(['>=', 'start_date', $this->start_date_from]);
        $query->andFilterWhere(['<=', 'start_date', $this->start_date_to]);
        $query->andFilterWhere([
            'like',
            new \yii\db\Expression('projects_activities.name'),
            $this->attrProjectsActivitiesMm
        ]);
        $query->andFilterWhere(['like', new \yii\db\Expression('organization.name'), $this->attrOrganizationMm]);
        $query->andFilterWhere([
            'like',
            new \yii\db\Expression('projects_task_statuses.name'),
            $this->attrProjectsTaskStatusesMm
        ]);
        $query->andFilterWhere(['like', new \yii\db\Expression('tasks.name'), $this->attrTasksMm]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchByActivity($params)
    {
        $query = ProjectsTasks::find()->andFilterWhere(['projects_activities.id' => $params['aid']])->orderBy('start_date');
        return $this->baseListsSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchByTask($params)
    {
        $query = ProjectsTasks::find()->andFilterWhere(['projects_tasks.id' => $params['tid']]);
        return $this->baseListsSearch($query, $params);
    }
}
