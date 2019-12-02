<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_tasks_projects_task_statuses_mm".
 *
 * @property integer $id
 * @property integer $projects_tasks_id
 * @property integer $projects_task_statuses_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsTaskStatuses $projectsTaskStatuses
 * @property \lispa\amos\projectmanagement\models\ProjectsTasks $projectsTasks
 */
class ProjectsTasksProjectsTaskStatusesMm extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_tasks_projects_task_statuses_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projects_tasks_id', 'projects_task_statuses_id'], 'required'],
            [['projects_tasks_id', 'projects_task_statuses_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [
                ['projects_task_statuses_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\ProjectsTaskStatuses::className(),
                'targetAttribute' => ['projects_task_statuses_id' => 'id']
            ],
            [
                ['projects_tasks_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\ProjectsTasks::className(),
                'targetAttribute' => ['projects_tasks_id' => 'id']
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
            'projects_tasks_id' => 'Projects Tasks ID',
            'projects_task_statuses_id' => 'Projects Task Statuses ID',
            'created_at' => 'Creato il',
            'updated_at' => 'Aggiornato il',
            'deleted_at' => 'Cancellato il',
            'created_by' => 'Creato da',
            'updated_by' => 'Aggiornato da',
            'deleted_by' => 'Cancellato da',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTaskStatuses()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsTaskStatuses::className(),
            ['id' => 'projects_task_statuses_id'])->inverseOf('projectsTasksProjectsTaskStatusesMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasks()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsTasks::className(),
            ['id' => 'projects_tasks_id'])->inverseOf('projectsTasksProjectsTaskStatusesMms');
    }
}
