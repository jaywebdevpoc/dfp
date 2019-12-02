<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_projects_states_mm".
 *
 * @property integer $id
 * @property integer $projects_id
 * @property integer $projects_states_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\Projects $projects
 * @property \lispa\amos\projectmanagement\models\ProjectsStates $projectsStates
 */
class ProjectsProjectsStatesMm extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_projects_states_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projects_id', 'projects_states_id'], 'required'],
            [['projects_id', 'projects_states_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [
                ['projects_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\Projects::className(),
                'targetAttribute' => ['projects_id' => 'id']
            ],
            [
                ['projects_states_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \lispa\amos\projectmanagement\ProjectsStates::className(),
                'targetAttribute' => ['projects_states_id' => 'id']
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
            'projects_id' => 'Projects ID',
            'projects_states_id' => 'Projects States ID',
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
    public function getProjects()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\Projects::className(),
            ['id' => 'projects_id'])->inverseOf('projectsProjectsStatesMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsStates()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsStates::className(),
            ['id' => 'projects_states_id'])->inverseOf('projectsProjectsStatesMms');
    }
}
