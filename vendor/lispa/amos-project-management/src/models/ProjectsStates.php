<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects_states".
 */
class ProjectsStates extends \lispa\amos\projectmanagement\models\base\ProjectsStates
{
    public function representingColumn()
    {
        return [
            'name',
        ];
    }
}
