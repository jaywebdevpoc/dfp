<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;


/**
 * This is the base-model class for table "projects_at_modify_request_mm".
 *
 * @property integer $id
 * @property integer $projects_activities_id
 * @property integer $projects_tasks_id
 * @property integer $projects_modify_request_id
 * @property \lispa\amos\projectmanagement\models\ProjectsTasks $projectsTasks
 * @property \lispa\amos\projectmanagement\models\ProjectsActivities $projectsActivities
 * @property \lispa\amos\projectmanagement\models\ProjectsModifyRequest $projectsModifyRequest
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 */
class ProjectsAtModifyRequestMm extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_at_modify_request_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projects_activities_id', 'projects_tasks_id', 'projects_modify_request_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['projects_activities_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsActivities::className(), 'targetAttribute' => ['projects_activities_id' => 'id']],
            [['projects_modify_request_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsModifyRequest::className(), 'targetAttribute' => ['projects_modify_request_id' => 'id']],
            [['projects_tasks_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsTasks::className(), 'targetAttribute' => ['projects_tasks_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('amosproject_management', 'ID'),
            'projects_activities_id' => Yii::t('amosproject_management', 'FK to projects_activities'),
            'projects_tasks_id' => Yii::t('amosproject_management', 'FK to projects_tasks'),
            'projects_modify_request_id' => Yii::t('amosproject_management', 'FK to projects_modify_request'),
            'created_at' => Yii::t('amosproject_management', 'Created At'),
            'updated_at' => Yii::t('amosproject_management', 'Updated At'),
            'deleted_at' => Yii::t('amosproject_management', 'Deleted At'),
            'created_by' => Yii::t('amosproject_management', 'Created By'),
            'updated_by' => Yii::t('amosproject_management', 'Updated By'),
            'deleted_by' => Yii::t('amosproject_management', 'Deleted By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTasks()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsTasks::className(),
            ['id' => 'projects_tasks_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivities()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsActivities::className(),
            ['id' => 'projects_activities_id']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsModifyRequest()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsModifyRequest::className(),
            ['id' => 'projects_modify_request_id']);
    }


}
