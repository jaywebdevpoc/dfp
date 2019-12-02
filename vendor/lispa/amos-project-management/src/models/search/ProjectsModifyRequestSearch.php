<?php

namespace lispa\amos\projectmanagement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;

/**
 * ProjectsModifyRequestSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsModifyRequest`.
 */
class ProjectsModifyRequestSearch extends ProjectsModifyRequest
{
    public $status_search;

    public function rules()
    {
        return [
            [['id', 'projects_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['status', 'status_search', 'description', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        //TODO modifica fatta perchè nella scheda progetto non esiste il pid in get, verificare se ha senso
        $pid = Yii::$app->request->get('pid') ?: Yii::$app->request->get('id');

        $query = ProjectsModifyRequest::find();
        $query->andWhere(['projects_id' => $pid]);
        $query->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'projects_id' => $this->projects_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);
/*
        $query->andFilterWhere(['like', 'status', $this->status_search])
            ->andFilterWhere(['like', 'description', $this->description]);
*/
        return $dataProvider;
    }

    public function searchMine($projectId, $params)
    {
        $query = ProjectsModifyRequest::find()
            ->andWhere([
                'created_by' => Yii::$app->user->id,
                'projects_id' => $projectId
            ]);
        $query->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'projects_id' => $this->projects_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status_search])
            ->andFilterWhere(['like', 'description', $this->description]);

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