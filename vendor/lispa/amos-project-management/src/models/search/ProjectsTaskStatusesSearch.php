<?php

namespace lispa\amos\projectmanagement\models\search;

use lispa\amos\projectmanagement\models\ProjectsTaskStatuses;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProjectsTaskStatusesSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsTaskStatuses`.
 */
class ProjectsTaskStatusesSearch extends ProjectsTaskStatuses
{
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
// bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectsTaskStatuses::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['projects_task_statuses.name' => SORT_ASC],
                    'desc' => ['projects_task_statuses.name' => SORT_DESC],
                ],
                'description' => [
                    'asc' => ['projects_task_statuses.description' => SORT_ASC],
                    'desc' => ['projects_task_statuses.description' => SORT_DESC],
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

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
