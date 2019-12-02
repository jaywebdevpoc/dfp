<?php

namespace lispa\amos\projectmanagement\models;

/**
 * Class ProjectsMeasure
 * This is the model class for table "projects_measure".
 * @package lispa\amos\projectmanagement\models
 */
class ProjectsMeasure extends \lispa\amos\projectmanagement\models\base\ProjectsMeasure
{
    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'name'
        ];
    }
}
