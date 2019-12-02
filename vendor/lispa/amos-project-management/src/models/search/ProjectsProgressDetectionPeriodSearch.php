<?php

namespace lispa\amos\projectmanagement\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * ProjectsProgressDetectionPeriodSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod`.
 */
class ProjectsProgressDetectionPeriodSearch extends ProjectsProgressDetectionPeriod
{
    public $status_search;

    public function rules()
    {
        return [
            [['id', 'projects_progress_detection_type_id', 'projects_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['status', 'status_search', 'warning_date', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'status_search' => Yii::t('amosproject_management', 'Status'),
            ]
        );
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ProjectsProgressDetectionPeriod::find();
        $query->orderBy('start_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'warning_date',
                    'start_date',
                    'end_date',
                    'projects_progress_detection_type_id' => [
                        'asc' => ['projects_progress_detection_type.name' => SORT_ASC],
                        'desc' => ['projects_progress_detection_type.name' => SORT_DESC],
                    ],
                    'status'
                ],
                'defaultOrder' => [
                    'start_date' => SORT_DESC
                ]
                ]
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'warning_date' => $this->warning_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
//            'percentage_completition' => $this->percentage_completition,
            'projects_progress_detection_type_id' => $this->projects_progress_detection_type_id,
            'projects_id' => $this->projects_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status_search]);

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

    public function searchByProject($params, $pid)
    {
        /** @var ActiveQuery $query */
        $query = ProjectsProgressDetectionPeriod::find();
        $query->andWhere(
            [
                'projects_id' => $pid,
            ]
        );
//        $query->orderBy('warning_date ASC');

        $query->innerJoinWith("projectsProgressDetectionType");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'warning_date',
                    'start_date',
                    'end_date',
                    'projects_progress_detection_type_id' => [
                        'asc' => ['projects_progress_detection_type.name' => SORT_ASC],
                        'desc' => ['projects_progress_detection_type.name' => SORT_DESC],
                    ],
                    'status'
                ],
                'defaultOrder' => [
                    'start_date' => SORT_DESC
                ]
            ]
        ]);

        $scope = $this->getScope($params);

        if (!($this->load($params, $scope) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'warning_date' => $this->warning_date,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
//            'percentage_completition' => $this->percentage_completition,
            'projects_progress_detection_type_id' => $this->projects_progress_detection_type_id,
            'projects_id' => $this->projects_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status_search]);

        return $dataProvider;
    }
}
