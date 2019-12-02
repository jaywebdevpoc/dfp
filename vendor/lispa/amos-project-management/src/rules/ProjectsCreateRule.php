<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules;

use lispa\amos\community\AmosCommunity;
use lispa\amos\community\models\Community;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use lispa\amos\utility\commands\UtilityController;
use Yii;
use yii\rbac\Rule;

class ProjectsCreateRule extends Rule
{

    public $name = 'projectsCreate';

    /**
     * Executes the rule.
     * Check if the community in this cwh-scope already have one project
     * AND If th user is COMMUNITY_MANAGER
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param \yii\rbac\Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
//        /** @var AmosCwh $moduleCwh */
//        $moduleCwh = Yii::$app->getModule('cwh');
//        if (isset($moduleCwh)) {
//            $scope = $moduleCwh->getCwhScope();
//            if (isset($scope['community'])) {
//                $project = Projects::find()->andWhere(['community_id' => $scope['community']])->one();
//                // first rule, the project is only one per community
//                if (empty($project)){
//                    // second rule, if the user is community_manager of this community
//                    /** @var AmosCommunity $communityModule */
//                    $communityModule = Yii::$app->getModule('community');
//                    if (!empty($communityModule)){
//                        $listOfCommunityIds = $communityModule->getCommunitiesManagedByUserId($user,true);
//                        return (in_array($scope['community'], $listOfCommunityIds));
//                    }
//                }
//            }
//        }
        return ProjectManagementUtility::loggedUsedIsCommunityManager();
    }

}