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
 * Class DeleteOwnPartnershipProfilesRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class DeleteOwnPartnershipProfilesRule extends OwnPartnershipProfileRule
{
    public $name = 'deleteOwnPartnershipProfiles';

    /**
     * @inheritdoc
     */
    public function partnershipProfileLogic($user, $item, $params, $model)
    {
        return (!count($model->expressionsOfInterest)); // Return true if the partnership profile doesn't have expressions of interest.
    }
}
