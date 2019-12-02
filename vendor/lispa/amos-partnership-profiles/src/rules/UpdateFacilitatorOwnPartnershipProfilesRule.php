<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\rules
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\rules;

/**
 * Class UpdateFacilitatorOwnPartnershipProfilesRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class UpdateFacilitatorOwnPartnershipProfilesRule extends FacilitatorOwnPartnershipProfilesRule
{
    public $name = 'updateFacilitatorOwnPartnershipProfiles';

    /**
     * @inheritdoc
     */
    public function facilitatorLogic($user, $item, $params, $model)
    {
        return true;
    }
}
