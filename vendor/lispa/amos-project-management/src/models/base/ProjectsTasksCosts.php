<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\projectmanagement\Module;
use Yii;

/**
 * This is the base-model class for table "projects_states".
 *
 * @property integer $id
 * @property integer $projects_tasks_id
 * @property integer $projects_custom_spending_voices_id
 * @property integer $organization_id
 * @property float $value
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsProjectsStatesMm[] $projectsProjectsStatesMms
 */
class ProjectsTasksCosts extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_tasks_costs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [
                [
                    'projects_tasks_id',
                    'projects_custom_spending_voices_id',
                    'organization_id',
                    'created_by',
                    'updated_by',
                    'deleted_by'
                ],
                'integer'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projects_tasks_id' => 'Task ID',
            'projects_custom_spending_voices_id' => 'Spending Voice ID',
            'organization_id' => 'Organization ID',
            'value' => 'Cost Value',
            'created_at' => Module::t('amosproject_management', 'Creato il'),
            'updated_at' => Module::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Module::t('amosproject_management', 'Cancellato il'),
            'created_by' => Module::t('amosproject_management', 'Creato da'),
            'updated_by' => Module::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Module::t('amosproject_management', 'Cancellato da'),
        ];
    }
}
