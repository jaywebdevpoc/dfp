<?php

namespace lispa\amos\projectmanagement\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects_user_mm".
 */
class ProjectsUserMm extends \lispa\amos\projectmanagement\models\base\ProjectsUserMm
{
    public function representingColumn()
    {
        return [
            //inserire il campo o i campi rappresentativi del modulo
        ];
    }

    public function attributeHints()
    {
        return [
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

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
        ]);
    }

    public function attributeLabels()
    {
        return
            ArrayHelper::merge(
                parent::attributeLabels(),
                [
                ]);
    }


    public static function getEditFields()
    {
        $labels = self::attributeLabels();

        return [
            [
                'slug' => 'projects_id',
                'label' => $labels['projects_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'user_id',
                'label' => $labels['user_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'projects_role_id',
                'label' => $labels['projects_role_id'],
                'type' => 'integer'
            ],
            [
                'slug' => 'organization_id',
                'label' => $labels['organization_id'],
                'type' => 'integer'
            ],
        ];
    }
}
