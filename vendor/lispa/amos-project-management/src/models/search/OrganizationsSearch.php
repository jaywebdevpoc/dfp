<?php

namespace lispa\amos\projectmanagement\models\search;

use lispa\amos\core\interfaces\OrganizationsModuleInterface;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\Module;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class OrganizationsSearch
 * @package lispa\amos\projectmanagement\models\search
 */
class OrganizationsSearch extends Model
{
    public function rules()
    {
        return [
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function activitiesProjectSearch($projectId, $params = [])
    {
        /** @var OrganizationsModuleInterface $moduleOrganizations */
        $moduleOrganizations = Module::instance()->getModuleOrganization();
        /** @var ActiveQuery $query */
        $query = $moduleOrganizations->getOrganizationsListQuery();
        /** @var $className */
        $className = $moduleOrganizations->getOrganizationModelClass();
        $tablename = $className::getTableSchema()->name;

//        $query->innerJoin('projects_activities_organization_mm',"$tablename.id = projects_activities_organization_mm.organization_id");
//        $query->innerJoin('projects_activities_projects_mm',"projects_activities_projects_mm.projects_activities_id = projects_activities_organization_mm.projects_activities_id");
//        $query->innerJoin('projects_activities',"projects_activities_projects_mm.projects_activities_id = projects_activities.id");
//        $query->andWhere(['projects_activities_projects_mm.projects_id' => $projectId]);
//        $query->andWhere('projects_activities.deleted_at IS NULL');

        $project = Projects::findOne($projectId);

        if($project) {
            /** @var ProjectsActivities $projectActivity */
            $projectActivities = $project->projectsActivities;
            $actvityOrg = [];
            foreach ($projectActivities as $projectActivity) {
                $actvityOrg = ArrayHelper::merge($actvityOrg, $projectActivity->getOrganizationIds());
            }
            $query->andWhere([$tablename . '.id' => $actvityOrg]);
        }
//        pr($query->createCommand()->rawSql);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orderBy(['created_at' => SORT_DESC]);

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

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function userOrganizationsSearch($userId = null){
        $className = \lispa\amos\projectmanagement\Module::getModuleOrganization()->getOrganizationModelClass();
        $dataProvider = new ActiveDataProvider([
            'query' => $className::find()->andWhere(0),
        ]);

        if($userId == null) {
            $userId = \Yii::$app->user->id;
        }
        $cwh = \Yii::$app->getModule("cwh");
        if (isset($cwh)) {
            $query = \lispa\amos\cwh\utility\CwhUtil::getUserNetworkQuery($className::getCwhConfigId(), $userId, false);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        }
        return $dataProvider;

    }
}
