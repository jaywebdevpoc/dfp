<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules\workflow
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules\workflow;

use lispa\amos\community\AmosCommunity;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use yii\rbac\Rule;

class ProjectsModifyRequestWorkflowOneditRule extends Rule
{

    public $name = 'projectsModifyRequestWorkflowOnedit';
    private $statusEnabled = [
        Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT,
        Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED,
    ];

    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     * @throws \lispa\amos\community\exceptions\CommunityException
     */
    public function execute($user, $item, $params)
    {
        /** @var AmosCwh $moduleCwh */
        $moduleCwh = \Yii::$app->getModule('cwh');
        $model = isset($params['model'])? $params['model']: null;



        if (!is_null($model) && ($model->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE)) {
//            pr($model->attributes);
            if (isset($moduleCwh)) {
                $scope = $moduleCwh->getCwhScope();
//                pr($scope);
                if (isset($scope['community'])) {
                    // second rule, if the user is community_manager of this community
                    /** @var AmosCommunity $communityModule */
                    $communityModule = \Yii::$app->getModule('community');
//                    pr($communityModule->name);
                    if (!empty($communityModule)) {
                        $listOfCommunityIds = $communityModule->getCommunitiesManagedByUserId($user, true);
//                        pr($scope['community']);
//                        pr($listOfCommunityIds);
//                        pr((in_array($scope['community'], $listOfCommunityIds))? 'OOOO': 'l');
                        return (in_array($scope['community'], $listOfCommunityIds));
                    }
                }
            }
        } else {
            if (isset($moduleCwh)) {
                $scope = $moduleCwh->getCwhScope();
                if (isset($scope['community'])) {
                    $project = Projects::find()->andWhere(['community_id' => $scope['community']])->one();
                    // first rule, the project is only one per community
                    if (!empty($project)) {
                        $responsiblesIds = $project->getProjectAllResponsiblesUsersWorkPaln();
                        if (in_array($project->status, $this->statusEnabled)) {
                            return in_array(\Yii::$app->user->id, $responsiblesIds);
                        }
                    }
                }
            }
        }
        return false;
    }
}