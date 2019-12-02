<?php

namespace lispa\amos\projectmanagement\models\search;

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsMeasure;
use lispa\amos\projectmanagement\models\ProjectsStates;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * ProjectsSearch represents the model behind the search form about `lispa\amos\projectmanagement\models\Projects`.
 */
class ProjectsSearch extends Projects
{
    /**
     * @var string $start_date_from
     */
    public $start_date_from;

    /**
     * @var string $start_date_to
     */
    public $start_date_to;

    /**
     * @var string $finish_date_from
     */
    public $finish_date_from;

    /**
     * @var string $finish_date_to
     */
    public $finish_date_to;

    /**
     * @var string $project_status
     */
    public $project_status;

    /**
     * @var string $project_measure_to_search
     */
    public $project_measure_to_search;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [[
                'name',
                'start_date_from',
                'start_date_to',
                'finish_date_from',
                'finish_date_to',
                'project_status',
                'project_measure_to_search',
                'created_at',
                'updated_at',
                'deleted_at'
            ], 'safe'],
            ['attrProjectsMeasureMm', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'start_date_from' => Module::t('amosproject_management', '#projects_search_start_date_from'),
            'start_date_to' => Module::t('amosproject_management', '#projects_search_start_date_to'),
            'finish_date_from' => Module::t('amosproject_management', '#projects_search_finish_date_from'),
            'finish_date_to' => Module::t('amosproject_management', '#projects_search_finish_date_to'),
            'project_status' => Module::t('amosproject_management', '#projects_search_project_status'),
            'project_measure_to_search' => Module::t('amosproject_management', '#projects_search_project_measure_to_search'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param ActiveQuery $query
     * @return ActiveQuery
     */
    public function baseFilter($query)
    {
        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.name', $this->name]);
        $query->andFilterWhere(['like', new Expression(ProjectsMeasure::tableName() . '.name'), $this->attrProjectsMeasureMm]);
        $query->andFilterWhere(['like', new Expression('organization.name'), $this->attrOrganizationMm]);
        $query->andFilterWhere(['like', new Expression('organization.name'), $this->attrJoinedOrganizationsMm]);
        $query->andFilterWhere(['>=', 'start_date', $this->start_date_from]);
        $query->andFilterWhere(['<=', 'start_date', $this->start_date_to]);
        $query->andFilterWhere(['>=', 'finish_date', $this->finish_date_from]);
        $query->andFilterWhere(['<=', 'finish_date', $this->finish_date_to]);
        $query->andFilterWhere([self::tableName() . '.status' => $this->project_status]);
        $query->andFilterWhere([ProjectsMeasure::tableName() . '.id' => $this->project_measure_to_search]);

        return $query;
    }

    /**
     * @param ActiveDataProvider $dataProvider
     * @return ActiveDataProvider
     */
    public function baseSort($dataProvider)
    {
        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => [self::tableName() . '.name' => SORT_ASC],
                    'desc' => [self::tableName() . '.name' => SORT_DESC],
                ],
                'summary' => [
                    'asc' => [self::tableName() . '.summary' => SORT_ASC],
                    'desc' => [self::tableName() . '.summary' => SORT_DESC],
                ],
                'insights' => [
                    'asc' => [self::tableName() . '.insights' => SORT_ASC],
                    'desc' => [self::tableName() . '.insights' => SORT_DESC],
                ],
                'finish_date' => [
                    'asc' => [self::tableName() . '.finish_date' => SORT_ASC],
                    'desc' => [self::tableName() . '.finish_date' => SORT_DESC],
                ],
                'website' => [
                    'asc' => [self::tableName() . '.website' => SORT_ASC],
                    'desc' => [self::tableName() . '.website' => SORT_DESC],
                ],
                'projectsStates' => [
                    'asc' => [ProjectsStates::tableName() . '.name' => SORT_ASC],
                    'desc' => [ProjectsStates::tableName() . '.name' => SORT_DESC],
                ],
                'organization' => [
                    'asc' => ['organization.name' => SORT_ASC],
                    'desc' => ['organization.name' => SORT_DESC],
                ],
                'projectsMeasure' => [
                    'asc' => [ProjectsMeasure::tableName() . '.name' => SORT_ASC],
                    'desc' => [ProjectsMeasure::tableName() . '.name' => SORT_DESC],
                ],
            ]
        ]);
        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /**
         * @var $query ActiveQuery
         */
        $query = Projects::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('projectsStates');
        $query->joinWith('organization');
        $query->joinWith('projectsMeasure');
        $query->orderBy(['created_at' => SORT_DESC]);

        $this->baseSort($dataProvider);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->baseFilter($query);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchMyProjects($params)
    {
        $user = Yii::$app->user;

        $dataProvider = $this->search($params);

        $dataProvider->query->joinWith('community');
        $dataProvider->query->joinWith('community.communityUsers');
        $dataProvider->query->andWhere(['user.id' => $user->id]);
        $setCommunity = false;
        if (ProjectManagementUtility::isSetCwhScope()) {
            /** @var AmosCwh $moduleCwh */
            $moduleCwh = \Yii::$app->getModule('cwh');
            if (isset($moduleCwh)) {
                $scope = $moduleCwh->getCwhScope();
                if (isset($scope['community'])) {
                    $dataProvider->query->andWhere([self::tableName() . '.community_id' => $scope['community']]);
                    $setCommunity = true;
                }
            }
        }

//        if (!$setCommunity) {
//            Yii::$app->session->addFlash('danger', Module::t('amosproject_management', 'You can\'t view the list of projects, scope not set'));
//            $dataProvider->query->andWhere([self::tableName() . '.community_id' => null]);
//        }

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchOwnProjects($params)
    {
        $dataProvider = $this->search($params);

        $dataProvider->query->joinWith('community');
        $dataProvider->query->joinWith('community.communityUsers');
        $dataProvider->query->andWhere(['user.id' => Yii::$app->user->id]);
        $dataProvider->query->andFilterWhere(['!=', new Expression(CommunityUserMm::tableName() . '.status'), CommunityUserMm::STATUS_WAITING_OK_USER]);

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

        $query->joinWith('projectsStates');
        $query->joinWith('organization');
        $query->joinWith('projectsMeasure');

        $this->baseSort($dataProvider);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->baseFilter($query);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchCreatedByProjects($params)
    {
        $query = Projects::find()->andFilterWhere(['projects.created_by' => Yii::$app->getUser()->getId()]);
        return $this->baseListsSearch($query, $params);
    }

    public function getAllActivitiesOrganizations($params = [])
    {
        /**
         * @var $query ActiveQuery
         */
        $query = Projects::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('projectsStates');
        $query->joinWith('organization');
        $query->joinWith('projectsMeasure');

        $query->orderBy(['created_at' => SORT_DESC]);

        $this->baseSort($dataProvider);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->baseFilter($query);

        return $dataProvider;

    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    /**public function searchMyProjects($params)
     * {
     * $query = Projects::find();
     * $query->innerJoin(CommunityUserMm::tableName(), 'projects.community_id = ' . CommunityUserMm::tableName() . '.community_id')
     * ->andWhere([
     * CommunityUserMm::tableName() . '.user_id' => Yii::$app->getUser()->getId(),
     * ])->andWhere(CommunityUserMm::tableName().'.deleted_at is null');
     * //        $query->andWhere([
     * //            'projects.status' => Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED
     * //        ])->orWhere([
     * //            'projects.status' => Projects::PROJECTS_WORKFLOW_STATUS_DRAFT,
     * //            'projects.validated_once' => 1,
     * //            'projects.visible_on_edit' => 1
     * //        ]);
     *
     * return $this->baseListsSearch($query, $params);
     * }**/
}
