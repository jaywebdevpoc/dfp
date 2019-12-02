<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_activities_projects_mm".
 *
 * @property integer $id
 * @property integer $projects_activities_id
 * @property integer $projects_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsActivities $projectsActivities
 * @property \lispa\amos\projectmanagement\models\Projects $projects
 */
class ProjectsActivitiesProjectsMm extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_activities_projects_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projects_activities_id', 'projects_id'], 'required'],
            [['projects_activities_id', 'projects_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [
                ['projects_activities_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\ProjectsActivities::className(),
                'targetAttribute' => ['projects_activities_id' => 'id']
            ],
            [
                ['projects_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\Projects::className(),
                'targetAttribute' => ['projects_id' => 'id']
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
            'projects_activities_id' => 'Projects Activities ID',
            'projects_id' => 'Projects ID',
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
    public function getProjectsActivities()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsActivities::className(),
            ['id' => 'projects_activities_id'])->inverseOf('projectsActivitiesProjectsMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\Projects::className(),
            ['id' => 'projects_id'])->inverseOf('projectsActivitiesProjectsMms');
    }
}
