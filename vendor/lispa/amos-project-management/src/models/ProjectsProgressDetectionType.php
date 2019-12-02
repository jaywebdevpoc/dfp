<?php

namespace lispa\amos\projectmanagement\models;

use lispa\amos\projectmanagement\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects_progress_detection_type".
 */
class ProjectsProgressDetectionType extends \lispa\amos\projectmanagement\models\base\ProjectsProgressDetectionType
{
    public static function getEditFields()
    {
        $labels = self::attributeLabels();

        return [
            [
                'slug' => 'name',
                'label' => $labels['name'],
                'type' => 'string'
            ],
            [
                'slug' => 'description',
                'label' => $labels['description'],
                'type' => 'text'
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

    public function getNameTranslate()
    {
        return Module::t('amosproject_management', $this->name);
    }
}
