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

use lispa\amos\core\record\Record;
use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use lispa\amos\projectmanagement\models\ProjectsTasks;

/**
 * Class ByCommunityRoleRule
 * @package lispa\amos\projectmanagement\rules
 */
abstract class ByCommunityRoleRule extends BasicContentRule
{
    public $name = 'byCommunityRole';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        if (is_null($model) || !$model->id) {
            $model = $this->findProjectsModel();
            if (is_null($model)) {
                return false;
            }
        }

        $model = $this->getModelProjects($model);
        if (is_null($model)) {
            return false;
        }

        $userCommunityRole = $model->getRawCommunityRoleByUserId($user);

        if (!$userCommunityRole) {
            return false;
        }

        return $this->checkCommunityRole($userCommunityRole);
    }

    /**
     * @return null|\lispa\amos\projectmanagement\models\Projects
     */
    protected function findProjectsModel()
    {
        $model = null;
        $get = \Yii::$app->getRequest()->get();
        $post = \Yii::$app->getRequest()->post();
        if(\Yii::$app->controller->id == 'projects' && \Yii::$app->controller->action->id == 'by-project') {
            if (isset($get['id'])) {
                $model = Projects::findOne($get['id']);
            } elseif (isset($post['id'])) {
                $model = Projects::findOne($post['id']);
            }
        }
        elseif (isset($get['pid'])) {
            $model = Projects::findOne($get['pid']);
        } elseif (isset($post['pid'])) {
            $model = Projects::findOne($post['pid']);
        } elseif (isset($get['projects_id'])) {
            $model = Projects::findOne($get['projects_id']);
        } elseif (isset($post['projects_id'])) {
            $model = Projects::findOne($post['projects_id']);
        } elseif (isset($get['expandRowKey'])) {
            $model = ProjectsActivities::findOne($get['expandRowKey']);
        } elseif (isset($post['expandRowKey'])) {
            $model = ProjectsActivities::findOne($post['expandRowKey']);
        } elseif (isset($get['activity_id'])) {
            $model = ProjectsActivities::findOne($get['activity_id']);
        } elseif (isset($post['activity_id'])) {
            $model = ProjectsActivities::findOne($post['activity_id']);
        }
        return $model;
    }

    /**
     * @param Record $model
     * @return null|\lispa\amos\projectmanagement\models\Projects
     */
    protected function getModelProjects($model)
    {
        if ($model instanceof Projects) {
            return $model;
        } elseif ($model instanceof ProjectsActivities) {
            return $model->projects;
        } elseif ($model instanceof ProjectsTasks) {
            return $model->projectsActivities->projects;
        }
        elseif ($model instanceof ProjectsModifyRequest) {
            return $model->projects;
        } else {
            return null;
        }
    }

    /**
     * @param string $userCommunityRole
     * @return bool
     */
    abstract protected function checkCommunityRole($userCommunityRole);
}
