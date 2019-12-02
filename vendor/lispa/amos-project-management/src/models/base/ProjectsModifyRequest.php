<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;


/**
 * This is the base-model class for table "projects_modify_request".
 *
 * @property integer $id
 * @property string $status
 * @property string $description
 * @property integer $projects_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\Projects $projects
 * @property \lispa\amos\projectmanagement\models\ProjectsAtModifyRequestMm[] $projectsAtModifyRequestMms
 */
class ProjectsModifyRequest extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_modify_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['description'], 'required'],
            [['projects_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['projects_id'], 'exist', 'skipOnError' => true, 'targetClass' => \lispa\amos\projectmanagement\models\Projects::className(), 'targetAttribute' => ['projects_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('amosproject_management', 'ID'),
            'status' => Yii::t('amosproject_management', 'Status'),
            'description' => Yii::t('amosproject_management', 'Description modify request'),
            'projects_id' => Yii::t('amosproject_management', 'FK to project'),
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
    public function getProjectsAtModifyRequestMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsAtModifyRequestMm::className(),
            ['projects_modify_request_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsActivities()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsActivities::className(),
            ['id' => 'projects_activities_id'])->via('projectsAtModifyRequestMms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\Projects::className(), ['id' => 'projects_id']);
    }

    public function getProjectsAtModifyRequestTaskIds()
    {
        return $this->getProjectsAtModifyRequestMms()->select('projects_tasks_id')->column();
    }

}
