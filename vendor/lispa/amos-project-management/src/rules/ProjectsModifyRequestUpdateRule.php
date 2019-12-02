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
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use yii\rbac\Rule;

class ProjectsModifyRequestUpdateRule extends Rule
{

    public $name = 'projectsModifyRequestUpdate';

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
        /** @var ProjectsModifyRequest $model */
        $model = isset($params['model']) ? $params['model'] : null;
        if (is_null($model)) return false;

        if ($model->isNewRecord) {
            $post = \Yii::$app->getRequest()->post();
            $get = \Yii::$app->getRequest()->get();
            if (isset($get['id'])) {
                $model = $this->instanceModel($model, $get['id']);
            } elseif (isset($post['id'])) {
                $model = $this->instanceModel($model, $post['id']);
            }
        }
        if($model->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_REJECTED) return false;

        $isComunityManager = false;

        // second rule, if the user is community_manager of this community
        /** @var AmosCommunity $communityModule */
        $communityModule = \Yii::$app->getModule('community');
        if (!empty($communityModule)) {
            $listOfCommunityIds = $communityModule->getCommunitiesManagedByUserId($user, true);
            if (!empty($model->projects)) {
                $isComunityManager = (in_array($model->projects->community_id, $listOfCommunityIds));
            }
        }

        if ($isComunityManager) {
            return true;
        } else {
            $can = ($model->created_by == \Yii::$app->user->id);
            $can &= ($model->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT);
            return $can;
        }
    }

    /**
     * @param ProjectsModifyRequest $model
     * @param int $modelId
     * @return mixed
     */
    private function instanceModel($model, $modelId)
    {
        /** @var ProjectsModifyRequest $instance */
        $instance = new ProjectsModifyRequest;
        $instancedModel = $instance::findOne($modelId);
        if (!is_null($instancedModel)) {
            $model = $instancedModel;
        }
        return $model;
    }

}