<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_task_statuses".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsTasksProjectsTaskStatusesMm[] $projectsTasksProjectsTaskStatusesMms
 */
class ProjectsTaskStatuses extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_task_statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
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
    public function getProjectsTasksProjectsTaskStatusesMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsTasksProjectsTaskStatusesMm::className(),
            ['projects_task_statuses_id' => 'id'])->inverseOf('projectsTaskStatuses');
    }
}
