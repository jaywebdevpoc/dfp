<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "projects_at_modify_request_mm".
 */
class ProjectsAtModifyRequestMm extends \lispa\amos\projectmanagement\models\base\ProjectsAtModifyRequestMm
{
    public static function getEditFields()
    {
        $labels = self::attributeLabels();

        return [
            [
                'slug' => 'projects_activities_id',
                'label' => $labels['projects_activities_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'projects_tasks_id',
                'label' => $labels['projects_tasks_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'projects_modify_request_id',
                'label' => $labels['projects_modify_request_id'],
                'type' => 'integer'
            ],
        ];
    }

    public function attributeLabels()
    {
        return
            ArrayHelper::merge(
                parent::attributeLabels(),
                [
                ]);
    }

    public function representingColumn()
    {
        return [
            //inserire il campo o i campi rappresentativi del modulo
        ];
    }

    /**
     * Returns the text hint for the specified attribute.
     * @param string $attribute the attribute name
     * @return string the attribute hint
     */
    public function getAttributeHint($attribute)
    {
        $hints = $this->attributeHints();
        return isset($hints[$attribute]) ? $hints[$attribute] : null;
    }

    public function attributeHints()
    {
        return [
        ];
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
        ]);
    }

    public function getStringIdForForm()
    {
        if (!empty($this->projectsTasks)) {
            return StringHelper::basename(ProjectsTasks::className()).$this->projects_tasks_id;
        }
        if (!empty($this->projectsActivities)) {
            return StringHelper::basename(ProjectsActivities::className()).$this->projects_activities_id;
        }
        return '';
    }
}
