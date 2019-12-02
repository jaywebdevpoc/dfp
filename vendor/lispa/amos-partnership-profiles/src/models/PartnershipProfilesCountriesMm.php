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
 * Class PartnershipProfilesCountriesMm
 * This is the model class for table "partnership_profiles_countries_mm".
 * @package lispa\amos\partnershipprofiles\models
 */
class PartnershipProfilesCountriesMm extends \lispa\amos\partnershipprofiles\models\base\PartnershipProfilesCountriesMm
{
    /**
     * @inheritdoc
     */
    public function representingColumn()
    {
        return [
            'partnership_profile_id',
            'country_id'
        ];
    }
}
