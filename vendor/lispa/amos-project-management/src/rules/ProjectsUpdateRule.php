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

use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;

/**
 * Class ProjectsUpdateRule
 * @package lispa\amos\projectmanagement\rules
 */
class ProjectsUpdateRule extends BasicProjectsUpdateDeleteRule
{
    public $name = 'projectsUpdate';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        if(ProjectManagementUtility::loggedUsedIsCommunityManager() ){
            return true;
        }

        if (is_null($model)) {
            return false;
        }
        /** @var Projects $model */
        $statusOk = $this->checkProjectStatus($model);
        return $statusOk;
    }
}
