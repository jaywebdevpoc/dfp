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
use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\cwh\AmosCwh;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use yii\rbac\Rule;
use Yii;

class ProjectsModifyRequestWorkflowValidatedRule extends BasicContentRule
{

    public $name = 'projectsModifyRequestWorkflowValidated';

    /**
     * @param int|string $user
     * @param \yii\rbac\Item $item
     * @param array $params
     * @param ProjectsModifyRequest $model
     * @return bool
     * @throws \lispa\amos\community\exceptions\CommunityException
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        /** @var Projects $project */
        $project = $model->projects;
        // first rule, the project is only one per community
        if (!empty($project)) {
            /** @var AmosCommunity $communityModule */
            $communityModule = Yii::$app->getModule('community');
            if (!empty($communityModule)) {
                $listOfCommunityIds = $communityModule->getCommunitiesManagedByUserId($user, true);
                return (in_array($project->community_id, $listOfCommunityIds));
            }
        }
        return false;
    }

}