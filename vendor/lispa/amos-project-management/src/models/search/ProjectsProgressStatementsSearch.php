<?php

namespace lispa\amos\projectmanagement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lispa\amos\projectmanagement\models\ProjectsProgressStatements;

/**
 * ProjectsProgressStatementsSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsProgressStatements`.
 */
class ProjectsProgressStatementsSearch extends ProjectsProgressStatements
{
    public function rules()
    {
        return [
            [['id', 'projects_progress_statements_type_id', 'projects_progress_detection_period_id', 'projects_task_id', 'user_responsible_id', 'organization_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['status', 'note', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectsProgressStatements::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'projects_progress_statements_type_id' => $this->projects_progress_statements_type_id,
            'projects_progress_detection_period_id' => $this->projects_progress_detection_period_id,
            'projects_task_id' => $this->projects_task_id,
            'user_responsible_id' => $this->user_responsible_id,
            'organization_id' => $this->organization_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

    public function getScope($params)
    {
        $scope = $this->formName();
        if (!isset($params[$scope])) {
            $scope = '';
        }
        return $scope;
    }
}