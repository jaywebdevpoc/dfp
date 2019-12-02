<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\utility
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\utility;

use lispa\amos\attachments\models\File;
use lispa\amos\community\AmosCommunity;
use lispa\amos\community\exceptions\CommunityException;
use lispa\amos\community\models\Community;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\projectmanagement\models\base\ProjectsTasksOrganizationMm;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsActivitiesOrganizationMm;
use lispa\amos\projectmanagement\models\ProjectsActivitiesProjectsMm;
use lispa\amos\projectmanagement\models\ProjectsMeasure;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksProjectsActivitiesMm;
use lispa\amos\projectmanagement\Module;
use lispa\amos\tag\models\EntitysTagsMm;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class ProjectManagementUtility
 * @package lispa\amos\projectmanagement\utility
 */
class ProjectManagementUtility
{
    /**
     * This method translate the array values.
     * @param array $arrayValues
     * @return array
     */
    public static function translateArrayValues($arrayValues)
    {
        $translatedArrayValues = [];
        foreach ($arrayValues as $key => $value) {
            $translatedArrayValues[$key] = Module::t('amosproject_management', $value);
        }
        return $translatedArrayValues;
    }

//    /**
//     * Create a community for a project.
//     * @param Projects $model
//     * @return Community|null
//     */
//    public static function createCommunity($model)
//    {
//        /** @var AmosCommunity $communityModule */
//        $communityModule = Yii::$app->getModule('community');
//        $title = ($model->name ? $model->name : '');
//        $type = CommunityType::COMMUNITY_TYPE_CLOSED;
//        $context = Projects::className();
//        $managerRole = $model->getManagerRole();
//        $description = ($model->insights ? $model->insights : '');
//        $community = null;
//        try {
//            $model->community_id = $communityModule->createCommunity($title, $type, $context, $managerRole,
//                $description, $model);
//            if ($model->community_id) {
//                $community = Community::findOne($model->community_id);
//            }
//        } catch (CommunityException $exception) {
//            \Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
//        }
//        return $community;
//    }

//    /**
//     * Update the community name and description. Return true if all ok and false in case of community save errors.
//     * @param Community $community
//     * @param string $communityName
//     * @param string $communityDescription
//     * @return bool
//     */
//    public static function updateCommunity($community, $communityName, $communityDescription)
//    {
//        $community->name = $communityName;
//        $community->description = $communityDescription;
//        $ok = $community->save(false);
//        return $ok;
//    }

    /**
     * @param Projects $model
     * @return bool
     */
    public static function duplicateTagForCommunity($model, $modelClassName)
    {
        $tags = EntitysTagsMm::findAll([
            'classname' => $modelClassName,
            'record_id' => $model->id
        ]);
        $ok = true;
        foreach ($tags as $tag) {
            $entityTag = new EntitysTagsMm();
            $entityTag->classname = Community::className();
            $entityTag->record_id = $model->community_id;
            $entityTag->tag_id = $tag->tag_id;
            $entityTag->root_id = $tag->root_id;
            $ok = $entityTag->save(false);
            if (!$ok) {
                break;
            }
        }
        return $ok;
    }

//    /**
//     * Utility for duplicate the model logo in the community logo.
//     * @param Projects $model
//     * @param string $logoField
//     * @param string $modelClassName
//     * @return bool
//     * @throws \Exception
//     * @throws \Throwable
//     * @throws \yii\db\StaleObjectException
//     */
//    public static function duplicateLogoForCommunity($model, $logoField, $modelClassName)
//    {
//        $ok = true;
//        $logo = File::findOne(['model' => $modelClassName, 'attribute' => $logoField, 'itemId' => $model->id]);
//        if (!is_null($logo)) {
//            $communityLogo = File::findOne([
//                'model' => Community::className(),
//                'attribute' => 'communityLogo',
//                'itemId' => $model->community_id
//            ]);
//            if (!is_null($communityLogo)) {
//                if ($logo->hash != $communityLogo->hash) {
//                    $communityLogo->delete();
//                    $ok = self::newCommunityLogo($model->community_id, $logo);
//                }
//            } else {
//                $ok = self::newCommunityLogo($model->community_id, $logo);
//            }
//        } else {
//            $communityLogo = File::findOne([
//                'model' => Community::className(),
//                'attribute' => 'communityLogo',
//                'itemId' => $model->community_id
//            ]);
//            if (!is_null($communityLogo)) {
//                $communityLogo->delete();
//            }
//        }
//        return $ok;
//    }

    /**
     * Utility for duplicate the model logo in the project logo.
     * @param Community $modelCommunity
     * @param Projects $modelProject
     * @param string $logoField
     * @param string $modelClassName
     * @return bool
     */
    public static function duplicateLogoFromCommunity(Community $modelCommunity, Projects $modelProject, $logoField, $modelClassName)
    {
        $ok = false;
        $logo = File::findOne(['model' => $modelClassName, 'attribute' => $logoField, 'itemId' => $modelCommunity->id]);
        if (!is_null($logo)) {
            $ok = self::newProjectLogo($modelProject->id, $logo);
        }
        return $ok;
    }

    /**
     * This method creates a logo duplicating the parameter logo data.
     * @param int $projectId
     * @param File $logo
     * @return bool
     */
    private static function newProjectLogo($projectId, $logo)
    {
        $projectLogo = new File();
        $logoAttributes = $logo->attributes;
        $toSkipFields = ['id', 'model', 'attribute', 'itemId'];
        foreach ($logoAttributes as $fieldName => $fieldValue) {
            if (!in_array($fieldName, $toSkipFields)) {
                $projectLogo->{$fieldName} = $fieldValue;
            }
        }
        $projectLogo->model = Projects::className();
        $projectLogo->attribute = 'logo';
        $projectLogo->itemId = $projectId;
        return $projectLogo->save();
    }

    /**
     * This method delete the community logo.
     * @param Projects $model
     */
    public static function deleteCommunityLogo($model)
    {
        $communityLogo = File::findOne([
            'model' => Community::className(),
            'attribute' => 'communityLogo',
            'itemId' => $model->community_id
        ]);
        if (!is_null($communityLogo)) {
            $communityLogo->delete();
        }
    }

    /**
     * @param int $currentRoleId
     * @return bool
     */
    public static function viewActivityPlanButton($currentRoleId)
    {
        return self::activityPlan($currentRoleId, self::activityRoles(), self::communityActivityRoles());
    }

    /**
     * @param int $currentRoleId
     * @param string[] $roles
     * @param string[] $communityRoles
     * @return bool
     */
    private static function activityPlan($currentRoleId, $roles, $communityRoles)
    {
        $viewActivityPlanByCommunityRole = (in_array($currentRoleId, $communityRoles));
        $viewActivityPlanByRBAC = false;
        foreach ($roles as $activityRole) {
            if (Yii::$app->getUser()->can($activityRole)) {
                $viewActivityPlanByRBAC = true;
                break;
            }
        }
        $viewActivityPlan = ($viewActivityPlanByCommunityRole || $viewActivityPlanByRBAC);
        //return true;
        return $viewActivityPlan;
    }

    /**
     * @return string[]
     */
    public static function activityRoles()
    {
        return [
            'PM_BY_COMMUNITY',
            'PR_BY_COMMUNITY',
            'COSTS_CREATOR'
        ];
    }

    /**
     * @return string[]
     */
    public static function communityActivityRoles()
    {
        return [
            'PROJECT_MANAGER',
            'COMMUNITY_MANAGER',
            'PARTICIPANT',
            'PARTNER_REFERENT'
        ];
    }

    /**
     * @param int $currentRoleId
     * @return bool
     */
    public static function editActivityPlan($currentRoleId)
    {
        return self::activityPlan($currentRoleId, self::editActivityRoles(), self::communityEditActivityRoles());
    }

    /**
     * @return string[]
     */
    public static function editActivityRoles()
    {
        return [
            'PM_BY_COMMUNITY'
        ];
    }

    /**
     * @return string[]
     */
    public static function communityEditActivityRoles()
    {
        return [
            'PROJECT_MANAGER'
        ];
    }

    /**
     * @param int $currentRoleId
     * @return bool
     */
    public static function seeActivityPlan($currentRoleId)
    {
        return self::activityPlan($currentRoleId, self::seeActivityRoles(), self::communitySeeActivityRoles());
    }

    /**
     * @return string[]
     */
    public static function seeActivityRoles()
    {
        return [
            'PR_BY_COMMUNITY',
            'COSTS_CREATOR'
        ];
    }

    /**
     * @return string[]
     */
    public static function communitySeeActivityRoles()
    {
        return [
            'PARTNER_REFERENT'
        ];
    }

    /**
     * @param int|null $communityId
     * @return bool
     * @throws CommunityException
     */
    public static function loggedUserIsCommunityManager($communityId = null)
    {
        return self::loggedUsedIsCommunityManager($communityId);
    }

    /**
     * @param int|null $communityId
     * @return bool
     * @throws CommunityException
     */
    public static function loggedUsedIsCommunityManager($communityId = null)
    {
        $isComunityManager = false;
        /** @var AmosCwh $moduleCwh */
        $moduleCwh = \Yii::$app->getModule('cwh');
        try {
            if (isset($moduleCwh) && !isset($communityId)) {
                $scope = $moduleCwh->getCwhScope();
                //Try to get community id to validate detect the manager
                $communityId = null;

                if (isset($scope['community'])) {
                    $communityId = $scope['community'];
                } else {
                    if (\Yii::$app->controller->id == 'projects' && \Yii::$app->controller->action->id == 'by-project') {
                        $projectId = Yii::$app->request->get('id');
                    } else if (\Yii::$app->controller->id == 'projects' && \Yii::$app->controller->action->id == 'update') {
                        $projectId = Yii::$app->request->get('id');
                    } else {
                        $projectId = Yii::$app->request->get('pid');
                    }
                    $project = Projects::findOne($projectId);
                    $communityId = $project->community_id;
                }
            }
        } catch (\Exception $e) {
            // DO NOTHING
        }

        if (!empty($communityId)) {
            // second rule, if the user is community_manager of this community
            /** @var AmosCommunity $communityModule */
            $communityModule = \Yii::$app->getModule('community');
            if (!empty($communityModule)) {
                $listOfCommunityIds = $communityModule->getCommunitiesManagedByUserId(Yii::$app->user->id, true);
                $isComunityManager = (in_array($communityId, $listOfCommunityIds));
            }
        }

        return $isComunityManager;
    }

    /**
     * @return bool
     */
    public static function isSetCwhScope()
    {
        /** @var AmosCwh $moduleCwh */
        $moduleCwh = \Yii::$app->getModule('cwh');
        if (isset($moduleCwh)) {
            $scope = $moduleCwh->getCwhScope();
            if (isset($scope['community'])) {
                return true;
            }
        }
        return false;
    }

    /**
     * This method creates a logo duplicating the parameter logo data.
     * @param int $communityId
     * @param File $logo
     * @return bool
     */
    private static function newCommunityLogo($communityId, $logo)
    {
        $communityLogo = new File();
        $logoAttributes = $logo->attributes;
        $toSkipFields = ['id', 'model', 'attribute', 'itemId'];
        foreach ($logoAttributes as $fieldName => $fieldValue) {
            if (!in_array($fieldName, $toSkipFields)) {
                $communityLogo->{$fieldName} = $fieldValue;
            }
        }
        $communityLogo->model = Community::className();
        $communityLogo->attribute = 'communityLogo';
        $communityLogo->itemId = $communityId;
        return $communityLogo->save();
    }

    /**
     * @param $community_id
     * @return bool
     */
    public static function isReferentWpOrActivity($community_id)
    {
        $loggedUser = \Yii::$app->user;
        $countWp = ProjectsActivitiesOrganizationMm::find()
            ->innerJoinWith('projectsActivities.projects')
            ->andWhere(['projects.community_id' => $community_id])
            ->andWhere(['projects_activities_organization_mm.user_id' => $loggedUser->id])->count();

        $countActivities = ProjectsTasksOrganizationMm::find()
            ->innerJoinWith('projectsTasks.projectsActivities.projects')
            ->andWhere(['projects.community_id' => $community_id])
            ->andWhere(['projects_tasks_organization_mm.user_id' => $loggedUser->id])->count();

        return ($countWp > 0 || $countActivities > 0);

    }

    /**
     * @param ProjectsTasks $task
     * @return bool
     */
    public static function isLoggedUserResponsibleTaskOrActivity(ProjectsTasks $task)
    {
        if (\Yii::$app->user->id == $task->getUserResponsibleId()) {
            return true;
        }

        $activity = $task->projectsActivities;
        if (\Yii::$app->user->id == $activity->getUserResponsibleId()) {
            return true;
        }

        return false;
    }

    /**
     * @param Projects $model
     * @return int
     */
    public static function getProjectTasksCount($model)
    {
        $projectId = $model->id;
        $projectsActivitiesTable = ProjectsActivities::tableName();
        $projectsActivitiesProjectsMmTable = ProjectsActivitiesProjectsMm::tableName();
        $projectsTasksTable = ProjectsTasks::tableName();
        $projectsTasksProjectsActivitiesMmTable = ProjectsTasksProjectsActivitiesMm::tableName();
        $query = new Query();
        $query->select(["$projectsTasksTable.id"])->distinct();
        $query->from($projectsActivitiesTable);
        $query->innerJoin($projectsActivitiesProjectsMmTable,
            "$projectsActivitiesTable.deleted_at IS NULL AND " .
            "$projectsActivitiesProjectsMmTable.deleted_at IS NULL AND " .
            "$projectsActivitiesProjectsMmTable.projects_id = '$projectId' AND " .
            "$projectsActivitiesProjectsMmTable.projects_activities_id = $projectsActivitiesTable.id"
        );
        $query->innerJoin($projectsTasksProjectsActivitiesMmTable,
            "$projectsTasksProjectsActivitiesMmTable.deleted_at IS NULL AND " .
            "$projectsActivitiesProjectsMmTable.projects_activities_id = $projectsTasksProjectsActivitiesMmTable.projects_activities_id"
        );
        $query->innerJoin($projectsTasksTable,
            "$projectsTasksTable.deleted_at IS NULL AND " .
            "$projectsTasksProjectsActivitiesMmTable.projects_tasks_id = $projectsTasksTable.id"
        );
        $count = $query->count();
        return $count;
    }

    /**
     * This method returns all the workflow statuses for the Projects model.
     * @return \raoul2000\workflow\base\StatusInterface[]
     * @throws \raoul2000\workflow\base\WorkflowException
     */
    public static function getProjectsWorkflowStatusesForSelect()
    {
        $model = new Projects();
        $workflowStates = $model->getWorkflowSource()->getWorkflow(Projects::PROJECTS_WORKFLOW)->getAllStatuses();
        $statusesForSelect = [];
        foreach ($workflowStates as $workflowStatus) {
            $statusesForSelect[$workflowStatus->getId()] = Module::t('amosproject_management', $workflowStatus->getLabel());
        }
        return $statusesForSelect;
    }

    /**
     * This method returns all the projects measures ready to be used in a select widget.
     * @return ProjectsMeasure[]
     */
    public static function getProjectsMeasuresForSelect()
    {
        return ArrayHelper::map(ProjectsMeasure::find()->all(), 'id', 'name');
    }
}
