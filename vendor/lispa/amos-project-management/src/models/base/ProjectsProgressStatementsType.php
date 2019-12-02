<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_progress_statements_type".
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
 */
class ProjectsProgressStatementsType extends \lispa\amos\core\record\Record
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_progress_statements_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'id' => Yii::t('amosproject_management', 'ID'),
            'name' => Yii::t('amosproject_management', 'Name'),
            'description' => Yii::t('amosproject_management', 'Description'),
            'created_at' => Yii::t('amosproject_management', 'Created At'),
            'updated_at' => Yii::t('amosproject_management', 'Updated At'),
            'deleted_at' => Yii::t('amosproject_management', 'Deleted At'),
            'created_by' => Yii::t('amosproject_management', 'Created By'),
            'updated_by' => Yii::t('amosproject_management', 'Updated By'),
            'deleted_by' => Yii::t('amosproject_management', 'Deleted By'),
        ];
    }

}
