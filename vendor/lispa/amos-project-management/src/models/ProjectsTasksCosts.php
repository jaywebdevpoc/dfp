<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;

//use backend\modules\cwh\behaviors\CwhNetworkBehaviors;
//use backend\modules\eventi\models\query\EventiQuery;
//use raoul2000\workflow\base\SimpleWorkflowBehavior;

/**
 * This is the model class for table "projects_states".
 */
class ProjectsTasksCosts extends \lispa\amos\projectmanagement\models\base\ProjectsTasksCosts
{
    public function representingColumn()
    {
        return [
            'name',
        ];
    }
}
