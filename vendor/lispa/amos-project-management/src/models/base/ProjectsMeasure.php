<?php

namespace lispa\amos\projectmanagement\models\base;

use lispa\amos\projectmanagement\Module;

/**
 * Class ProjectsMeasure
 *
 * This is the base-model class for table "projects_measure".
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
 * @property \lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm[] $projectsProjectsMeasureMms
 *
 * @package lispa\amos\projectmanagement\models\base
 */
class ProjectsMeasure extends \lispa\amos\core\record\Record
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_measure';
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
            'name' => Module::t('amosproject_management', '#project_measure_name'),
            'description' => Module::t('amosproject_management', 'Description'),
            'created_at' => Module::t('amosproject_management', 'Creato il'),
            'updated_at' => Module::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Module::t('amosproject_management', 'Cancellato il'),
            'created_by' => Module::t('amosproject_management', 'Creato da'),
            'updated_by' => Module::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Module::t('amosproject_management', 'Cancellato da'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsProjectsMeasureMms()
    {
        return $this->hasMany(\lispa\amos\projectmanagement\models\ProjectsProjectsMeasureMm::className(), ['projects_measure_id' => 'id'])->inverseOf('projectsMeasure');
    }
}
