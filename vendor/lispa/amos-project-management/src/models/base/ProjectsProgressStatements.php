<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\core\interfaces\OrganizationsModuleInterface;
use lispa\amos\core\user\User;
use lispa\amos\projectmanagement\Module;
use Yii;

/**
 * This is the base-model class for table "projects_progress_statements".
 *
 * @property integer $id
 * @property string $status
 * @property string $note
 * @property integer $projects_progress_statements_type_id
 * @property integer $projects_progress_detection_period_id
 * @property integer $projects_task_id
 * @property integer $user_responsible_id
 * @property integer $organization_id
 * @property string $last_confirmed_time
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $projectsProgressDetectionPeriod
 * @property \lispa\amos\projectmanagement\models\ProjectsTasks $projectsTask
 * @property \lispa\amos\projectmanagement\models\ProjectsProgressStatementsType $projectsProgressStatementsType
 * @property User $userResponsible
 */
class ProjectsProgressStatements extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_progress_statements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note'], 'string'],
            [['projects_progress_statements_type_id', 'projects_progress_detection_period_id', 'projects_task_id', 'user_responsible_id', 'organization_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'last_confirmed_time', 'updated_at', 'deleted_at'], 'safe'],
            [['status'], 'string', 'max' => 255],
            [['projects_progress_detection_period_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsProgressDetectionPeriod::className(), 'targetAttribute' => ['projects_progress_detection_period_id' => 'id']],
            [['projects_task_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsTasks::className(), 'targetAttribute' => ['projects_task_id' => 'id']],
            [['projects_progress_statements_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsProgressStatementsType::className(), 'targetAttribute' => ['projects_progress_statements_type_id' => 'id']],
            [['user_responsible_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_responsible_id' => 'id']],
            [['projects_progress_statements_type_id', 'note'], 'required'],
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
            'note' => Yii::t('amosproject_management', 'Note'),
            'projects_progress_statements_type_id' => Yii::t('amosproject_management', 'FK to projects_progress_statements_type'),
            'projects_progress_detection_period_id' => Yii::t('amosproject_management', 'FK to projects_progress_detection_period'),
            'projects_task_id' => Yii::t('amosproject_management', 'FK to projects_task'),
            'user_responsible_id' => Yii::t('amosproject_management', 'FK to user_id the responsible of task'),
            'organization_id' => Yii::t('amosproject_management', 'Organization responsible'),
            'last_confirmed_time' => Yii::t('amosproject_management', 'Last confirmed time'),
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
    public function getProjectsProgressDetectionPeriod()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::className(), ['id' => 'projects_progress_detection_period_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsTask()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsTasks::className(), ['id' => 'projects_task_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressStatementsType()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsProgressStatementsType::className(), ['id' => 'projects_progress_statements_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserResponsible()
    {
        return $this->hasOne(User::className(), ['id' => 'user_responsible_id']);
    }

    /**
     * @return array|ProjectsProgressStatements|null|\yii\db\ActiveRecord
     */
    public function getOrganizationResponsible()
    {
        /** @var OrganizationsModuleInterface $orgModule */
        $orgModule = Module::getModuleOrganization();
        $orgClass = $orgModule->getOrganizationModelClass();
        $query = $this->hasOne($orgClass, ['id' => 'organization_id']);
        return $query;
    }
}
