<?php

namespace lispa\amos\projectmanagement\models\search;

use lispa\amos\projectmanagement\models\ProjectsActivities;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProjectsActivitiesSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsActivities`.
 */
class ProjectsActivitiesSearch extends ProjectsActivities
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            ['attrProjectsMm', 'safe'],
            ['attrOrganizationMm', 'safe'],
        ];
    }

    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectsActivities::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('projects');
        $query->joinWith('organization');

        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['projects_activities.name' => SORT_ASC],
                    'desc' => ['projects_activities.name' => SORT_DESC],
                ],
                'description' => [
                    'asc' => ['projects_activities.description' => SORT_ASC],
                    'desc' => ['projects_activities.description' => SORT_DESC],
                ],
                'projects' => [
                    'asc' => ['projects.name' => SORT_ASC],
                    'desc' => ['projects.name' => SORT_DESC],
                ],
                'organization' => [
                    'asc' => ['organization.name' => SORT_ASC],
                    'desc' => ['organization.name' => SORT_DESC],
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
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
        $query->andFilterWhere(['like', new \yii\db\Expression('projects.name'), $this->attrProjectsMm]);
        $query->andFilterWhere(['like', new \yii\db\Expression('organization.name'), $this->attrOrganizationMm]);

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

        $query->joinWith('projects');
        $query->joinWith('organization');

        $query->orderBy('projects_activities.id ASC');
//        $dataProvider->setSort([
//            'attributes' => [
//                'name' => [
//                    'asc' => ['projects_activities.name' => SORT_ASC],
//                    'desc' => ['projects_activities.name' => SORT_DESC],
//                ],
//                'description' => [
//                    'asc' => ['projects_activities.description' => SORT_ASC],
//                    'desc' => ['projects_activities.description' => SORT_DESC],
//                ],
//                'projects' => [
//                    'asc' => ['projects.name' => SORT_ASC],
//                    'desc' => ['projects.name' => SORT_DESC],
//                ],
//                'organization' => [
//                    'asc' => ['organization.name' => SORT_ASC],
//                    'desc' => ['organization.name' => SORT_DESC],
//                ],
//            ]
//        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'finish_date' => $this->finish_date,
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
        $query->andFilterWhere(['like', new \yii\db\Expression('projects.name'), $this->attrProjectsMm]);
        $query->andFilterWhere(['like', new \yii\db\Expression('organization.name'), $this->attrOrganizationMm]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchByProjects($params)
    {
        $query = ProjectsActivities::find()->andFilterWhere(['projects.id' => $params['pid']]);
        return $this->baseListsSearch($query, $params);
    }
}
