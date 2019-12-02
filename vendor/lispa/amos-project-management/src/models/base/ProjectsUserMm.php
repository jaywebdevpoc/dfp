<?php

namespace lispa\amos\projectmanagement\models\base;

use Yii;

/**
 * This is the base-model class for table "projects_user_mm".
 *
 * @property integer $id
 * @property integer $projects_id
 * @property integer $user_id
 * @property integer $projects_role_id
 * @property integer $organization_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 *
 * @property Projects $projects
 * @property \lispa\amos\core\user\User $user
 */
class ProjectsUserMm extends \lispa\amos\core\record\Record
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects_user_mm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projects_id', 'user_id'], 'required'],
            [['projects_id', 'user_id', 'projects_role_id', 'organization_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['projects_id'], 'exist', 'skipOnError' => true, 'targetClass' => Projects::className(), 'targetAttribute' => ['projects_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \lispa\amos\core\user\User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('amosproject_management', 'ID'),
            'projects_id' => Yii::t('amosproject_management', 'Project'),
            'user_id' => Yii::t('amosproject_management', 'User'),
            'projects_role_id' => Yii::t('amosproject_management', 'Role'),
            'organization_id' => Yii::t('amosproject_management', 'Organization'),
            'created_at' => Yii::t('amosproject_management', 'Creato il'),
            'updated_at' => Yii::t('amosproject_management', 'Aggiornato il'),
            'deleted_at' => Yii::t('amosproject_management', 'Cancellato il'),
            'created_by' => Yii::t('amosproject_management', 'Creato da'),
            'updated_by' => Yii::t('amosproject_management', 'Aggiornato da'),
            'deleted_by' => Yii::t('amosproject_management', 'Cancellato da'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasOne(Projects::className(), ['id' => 'projects_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\lispa\amos\core\user\User::className(), ['id' => 'user_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsRoles()
    {
        return $this->hasOne(ProjectsRoles::className(), ['id' => 'projects_role_id']);
    }
}
