<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

//use backend\modules\cwh\behaviors\CwhNetworkBehaviors;
//use backend\modules\eventi\models\query\EventiQuery;
//use raoul2000\workflow\base\SimpleWorkflowBehavior;

/**
 * This is the model class for table "projects_tasks_tasks_mm".
 * @property string $typeName
 * @property integer $typeNumber
 * @property string $dependencyStatus
 */
class ProjectsTasksTasksMm extends \lispa\amos\projectmanagement\models\base\ProjectsTasksTasksMm
{
    const S2S_MISMATCH = 1;
    const F2F_MISMATCH = 2;
    const S2F_MISMATCH = 3;
    const F2S_MISMATCH = 4;
    const S2S_MISMATCH_MSG = '#S2S_MISMATCH_MSG';
    const F2F_MISMATCH_MSG = '#F2F_MISMATCH_MSG';
    const S2F_MISMATCH_MSG = '#S2F_MISMATCH_MSG';
    const F2S_MISMATCH_MSG = '#F2S_MISMATCH_MSG';

    const START_TO_START = 1;
    const START_TO_FINISH = 3;
    const FINISH_TO_START = 0;
    const FINISH_TO_FINISH = 2;

    static $arrayTypes = [
        'finish_to_finish' => self::FINISH_TO_FINISH,
        'finish_to_start' => self::FINISH_TO_START,
        'start_to_finish' => self::START_TO_FINISH,
        'start_to_start' => self::START_TO_START
    ];

    public function representingColumn()
    {
        return [
            'tasks_id',
        ];
    }

    public function getTypeName()
    {
        return self::getTypeNameBySlug($this->type);
    }

    /**
     * @param $slug
     * @return string
     */
    public static function getTypeNameBySlug($slug)
    {
        $arrayTypes = [
            'finish_to_finish' => Module::t('amosproject_management', 'Finish To Finish'),
            'finish_to_start' => Module::t('amosproject_management', 'Finish To Start'),
            'start_to_finish' => Module::t('amosproject_management', 'Start To Finish'),
            'start_to_start' => Module::t('amosproject_management', 'Start To Start')
        ];

        return $arrayTypes[$slug];
    }

    /**
     * @param int $number
     * @return string
     */
    public static function getTypeNameByNumber($number)
    {
        $slug = self::typeNumberToIdentiffier($number);
        return self::getTypeNameBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function getTypeNumber()
    {
        return self::$arrayTypes[$this->type];
    }

    /**
     * @param int $number
     * @return string
     */
    public static function typeNumberToIdentiffier($number)
    {
        foreach (self::$arrayTypes as $type => $numeric) {
            if ($number == $numeric) {
                return $type;
            }
        }

        return 'start_to_finish';
    }

    /**
     * @return bool|int
     */
    public function hasDependencyError($inverse = false)
    {
        $relationFrom = $inverse ? 'projectsTasks' : 'requiredTasks';
        $relationTo = $inverse ? 'requiredTasks' : 'projectsTasks';

        $timeRelFromStartDate = $this->{$relationFrom}->startDate;
        $timeRelFromEndDate = $this->{$relationFrom}->endDate;

        $timeRelToStartDate = $this->{$relationTo}->startDate;
        $timeRelToEndDate = $this->{$relationTo}->endDate;

        // Switch Relation Type
        switch ($this->type) {
            case 'start_to_start': {
                if ($timeRelFromStartDate < $timeRelToStartDate) {
                    return self::S2S_MISMATCH;
                }
            }
                break;
            case 'finish_to_finish': {
                if ($timeRelFromEndDate < $timeRelToEndDate) {
                    return self::F2F_MISMATCH;
                }
            }
                break;
            case 'start_to_finish': {
                if ($timeRelFromEndDate < $timeRelToStartDate) {
                    return self::S2F_MISMATCH;
                }
            }
                break;
            case 'finish_to_start': {
                if ($timeRelFromStartDate < $timeRelToEndDate) {
                    return self::F2S_MISMATCH;
                }
            }
                break;
        }

        return false;
    }

    /**
     * Prepend icon if it has a relation error
     * @return string
     */
    public function getDependencyStatus()
    {
        return $this->hasDependencyError() ? AmosIcons::show('alert-triangle') : AmosIcons::show('check-circle');
    }

    /**
     * Prepend icon if it has a relation error
     * @return string
     */
    public function getInverseDependencyStatus()
    {
        return $this->hasDependencyError(true) ? AmosIcons::show('alert-triangle') : AmosIcons::show('check-circle');
    }

}
