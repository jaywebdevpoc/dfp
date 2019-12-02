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

use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\projectmanagement\models\Projects;

/**
 * Class BasicProjectsUpdateDeleteRule
 * @package lispa\amos\projectmanagement\rules
 */
abstract class BasicProjectsUpdateDeleteRule extends BasicContentRule
{
    /**
     * @param Projects $model
     * @return bool
     */
    public function checkProjectStatus($model)
    {
        $allowedStatuses = [
            Projects::PROJECTS_WORKFLOW_STATUS_STARTUP,
            Projects::PROJECTS_WORKFLOW_STATUS_ONEDIT
        ];
        return (in_array($model->status, $allowedStatuses));
    }
}
