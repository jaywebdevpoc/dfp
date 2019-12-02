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

use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\projectmanagement\models\ProjectsActivities;

class ProjectsValidatedWorkflowRule extends BasicContentRule
{

    public $name = 'ProjectsValidatedWorkflow';

    public function ruleLogic($user, $item, $params, $model)
    {
        if(!empty($model)){
            $activities = $model->projectsActivities;
            if(count($model->projectsActivities) == 0) {
                return false;
            }

            /** @var  $activity ProjectsActivities*/
            $count = 0;
            foreach ($activities as $activity){
                $count += count($activity->projectsTasks);
            }
            return ($count > 0);
        }

        return false;
    }
}