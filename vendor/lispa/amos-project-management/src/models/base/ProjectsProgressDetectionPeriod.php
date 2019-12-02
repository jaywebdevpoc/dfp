<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\projectmanagement\Module;
use Yii;

/**
 * This is the base-model class for table "projects_progress_detection_period".
 *
 * @property integer $id
 * @property string $status
 * @property string $warning_date
 * @property string $start_date
 * @property string $end_date
 * @property integer $projects_progress_detection_type_id
 * @property integer $projects_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property \lispa\amos\projectmanagement\models\Projects $projects
 * @property \lispa\amos\projectmanagement\models\ProjectsProgressDetectionType $projectsProgressDetectionType
 * @property \lispa\amos\projectmanagement\models\ProjectsProgressStatements[] $projectsProgressStatements
 */
class ProjectsProgressDetectionPeriod extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_progress_detection_period';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warning_date', 'start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['warning_date', 'start_date', 'end_date', 'projects_progress_detection_type_id'], 'required'],
            [['projects_progress_detection_type_id', 'projects_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['projects_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['projects_id' => 'id']],
            [['projects_progress_detection_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectsProgressDetectionType::className(), 'targetAttribute' => ['projects_progress_detection_type_id' => 'id']],
//            ['warning_date', 'compare', 'compareAttribute' => 'start_date', 'operator' => '<=', 'enableClientValidation' => true],
//            ['start_date', 'compare', 'compareAttribute' => 'end_date', 'operator' => '<=', 'enableClientValidation' => true],
            [['start_date', 'end_date', 'warning_date'], 'validateDates']
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
            'warning_date' => Yii::t('amosproject_management', 'Warning date'),
            'start_date' => Yii::t('amosproject_management', 'Start Date'),
            'end_date' => Yii::t('amosproject_management', 'End Date'),
//            'percentage_completition' => Yii::t('amosproject_management', 'Percentage completition'),
            'projects_progress_detection_type_id' => Yii::t('amosproject_management', 'Type of detection'),
            'projects_id' => Yii::t('amosproject_management', 'FK to project'),
            'created_at' => Yii::t('amosproject_management', 'Created At'),
            'updated_at' => Yii::t('amosproject_management', 'Updated At'),
            'deleted_at' => Yii::t('amosproject_management', 'Deleted At'),
            'created_by' => Yii::t('amosproject_management', 'Created By'),
            'updated_by' => Yii::t('amosproject_management', 'Updated By'),
            'deleted_by' => Yii::t('amosproject_management', 'Deleted By'),
        ];
    }


    public function validateDates()
    {
        // case 1
        if (!empty($this->start_date) && !empty($this->end_date)) {
            if (strtotime($this->end_date) <= strtotime($this->start_date)) {
                if (empty($this->getFirstError('start_date'))) {
                    $this->addError('start_date', Module::t('amosproject_management', 'Start date must be set before finish date'));
                }
                if (empty($this->getFirstError('end_date'))) {
                    $this->addError('end_date', Module::t('amosproject_management', 'Finish date must be set after start date'));
                }
                return;
            }
        }

        // case 2
        if (!empty($this->warning_date) && !empty($this->start_date)) {
            if (strtotime($this->warning_date) > strtotime($this->start_date)) {
                if (empty($this->getFirstError('start_date'))) {
                    $this->addError('start_date', Module::t('amosproject_management', 'Start date must be set after warning date'));
                }
                if (empty($this->getFirstError('warning_date'))) {
                    $this->addError('warning_date', Module::t('amosproject_management', 'Warning date must be set before start date'));
                }
                return;
            }
        }

        // case 3
        $listOfDp = self::find()->andWhere([
            'projects_id' => $this->projects_id,
            'projects_progress_detection_type_id' => $this->projects_progress_detection_type_id,
        ])->all();
        $error = false;
        /** @var \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $dp */
        foreach ($listOfDp as $dp) {
            if ($this->isNewRecord || ($this->id != $dp->id)) {
                if (
                !(
                    ((strtotime($dp->start_date) < strtotime($this->start_date)) && (strtotime($dp->end_date) < strtotime($this->start_date)))
                    ||
                    ((strtotime($dp->start_date) > strtotime($this->end_date)) && (strtotime($dp->end_date) > strtotime($this->end_date)))
                )
                ) {
                    $error = true;
                }
            }
        }
        if ($error) {
            $this->addError('start_date', Module::t('amosproject_management', '#ERROR_OVERLAPPED_PERIOD'));
            $this->addError('end_date', Module::t('amosproject_management', '#ERROR_OVERLAPPED_PERIOD'));
        }

    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\Projects::className(), ['id' => 'projects_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressDetectionType()
    {
        return $this->hasOne(\lispa\amos\projectmanagement\models\ProjectsProgressDetectionType::className(), ['id' => 'projects_progress_detection_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressStatements()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProgressStatements::className(), ['projects_progress_detection_period_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProgressCosts()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProgressCosts::className(), ['projects_progress_detection_period_id' => 'id']);
    }
}
