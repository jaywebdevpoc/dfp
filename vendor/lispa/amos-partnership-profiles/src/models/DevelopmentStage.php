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
 * Class DevelopmentStage
 * This is the model class for table "development_stage".
 * @package lispa\amos\partnershipprofiles\models
 */
class DevelopmentStage extends \lispa\amos\partnershipprofiles\models\base\DevelopmentStage
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
