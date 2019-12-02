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
 * Class UpdateOwnPartnershipProfilesRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class UpdateOwnPartnershipProfilesRule extends OwnPartnershipProfileRule
{
    public $name = 'updateOwnPartnershipProfiles';

    /**
     * @inheritdoc
     */
    public function partnershipProfileLogic($user, $item, $params, $model)
    {
        return true;
    }
}
