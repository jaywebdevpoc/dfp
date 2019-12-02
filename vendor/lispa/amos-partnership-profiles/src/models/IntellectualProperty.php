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
 * Class IntellectualProperty
 * This is the model class for table "intellectual_property".
 * @package lispa\amos\partnershipprofiles\models
 */
class IntellectualProperty extends \lispa\amos\partnershipprofiles\models\base\IntellectualProperty
{
    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'value'
        ];
    }
}
