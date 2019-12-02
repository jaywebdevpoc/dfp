<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects_tasks_joined_organization_mm".
 */
class ProjectsTasksJoinedOrganizationsMm extends \lispa\amos\projectmanagement\models\base\ProjectsTasksJoinedOrganizationsMm
{
    public function representingColumn()
    {
        return [
            'organization_id',
        ];
    }
}
