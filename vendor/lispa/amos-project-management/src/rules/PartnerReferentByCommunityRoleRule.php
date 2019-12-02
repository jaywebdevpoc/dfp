<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules;

use lispa\amos\projectmanagement\models\Projects;

/**
 * Class PartnerReferentByCommunityRoleRule
 * @package lispa\amos\projectmanagement\rules
 */
class PartnerReferentByCommunityRoleRule extends ByCommunityRoleRule
{
    public $name = 'partnerReferentByCommunityRole';

    /**
     * @inheritdoc
     */
    protected function checkCommunityRole($userCommunityRole)
    {
        return ($userCommunityRole === Projects::ROLE_PARTNER_REFERENT);
    }
}
