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
 * Class PartnershipProfilesType
 * This is the model class for table "partnership_profiles_type".
 * @package lispa\amos\partnershipprofiles\models
 */
class PartnershipProfilesType extends \lispa\amos\partnershipprofiles\models\base\PartnershipProfilesType
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
