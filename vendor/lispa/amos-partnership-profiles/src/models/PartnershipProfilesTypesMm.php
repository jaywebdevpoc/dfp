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
 * Class PartnershipProfilesTypesMm
 * This is the model class for table "partnership_profiles_types_mm".
 * @package lispa\amos\partnershipprofiles\models
 */
class PartnershipProfilesTypesMm extends \lispa\amos\partnershipprofiles\models\base\PartnershipProfilesTypesMm
{
    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'partnership_profile_id',
            'partnership_profiles_type_id'
        ];
    }
}
