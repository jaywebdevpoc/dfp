<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\models
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\models;

/**
 * Class WorkLanguage
 * This is the model class for table "work_language".
 * @package lispa\amos\partnershipprofiles\models
 */
class WorkLanguage extends \lispa\amos\partnershipprofiles\models\base\WorkLanguage
{
    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'work_language'
        ];
    }
}
