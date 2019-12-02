<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_roles".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 */
class ProjectsRoles extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => Yii::t('amosproject_management', 'Role'),
            'created_at' => Yii::t('amosproject_management', 'Creato il'),
            'updated_at' => Yii::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Yii::t('amosproject_management', 'Cancellato il'),
            'created_by' => Yii::t('amosproject_management', 'Creato da'),
            'updated_by' => Yii::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Yii::t('amosproject_management', 'Cancellato da'),
        ];
    }
}
