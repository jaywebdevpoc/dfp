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
 * Class DeleteFacilitatorOwnPartnershipProfilesRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class DeleteFacilitatorOwnPartnershipProfilesRule extends FacilitatorOwnPartnershipProfilesRule
{
    public $name = 'deleteFacilitatorOwnPartnershipProfiles';

    /**
     * @inheritdoc
     */
    public function facilitatorLogic($user, $item, $params, $model)
    {
        return (!count($model->expressionsOfInterest)); // Return true if the partnership profile doesn't have expressions of interest.
    }
}
