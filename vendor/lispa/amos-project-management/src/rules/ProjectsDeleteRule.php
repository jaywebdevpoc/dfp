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

/**
 * Class ProjectsDeleteRule
 * @package lispa\amos\projectmanagement\rules
 */
class ProjectsDeleteRule extends BasicProjectsUpdateDeleteRule
{
    public $name = 'projectsDelete';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        if (is_null($model)) {
            return false;
        }
        /** @var Projects $model */
        $statusOk = $this->checkProjectStatus($model);
        return $statusOk;
    }
}
