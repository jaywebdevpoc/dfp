<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\partnershipprofiles\rules\DeleteFacilitatorOwnExprOfIntRule;
use lispa\amos\partnershipprofiles\rules\DeleteFacilitatorOwnPartnershipProfilesRule;
use lispa\amos\partnershipprofiles\rules\UpdateFacilitatorOwnExprOfIntRule;
use lispa\amos\partnershipprofiles\rules\UpdateFacilitatorOwnPartnershipProfilesRule;

/**
 * Class m180109_102840_fix_partnership_profiles_facilitator_permissions
 */
class m180109_102840_fix_partnership_profiles_facilitator_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'PARTNERSHIPPROFILES_UPDATE',
                'update' => true,
                'newValues' => [
                    'addParents' => [UpdateFacilitatorOwnPartnershipProfilesRule::className()]
                ]
            ],
            [
                'name' => 'PARTNERSHIPPROFILES_DELETE',
                'update' => true,
                'newValues' => [
                    'addParents' => [DeleteFacilitatorOwnPartnershipProfilesRule::className()]
                ]
            ],
            [
                'name' => 'EXPRESSIONSOFINTEREST_UPDATE',
                'update' => true,
                'newValues' => [
                    'addParents' => [UpdateFacilitatorOwnExprOfIntRule::className()]
                ]
            ],
            [
                'name' => 'EXPRESSIONSOFINTEREST_DELETE',
                'update' => true,
                'newValues' => [
                    'addParents' => [DeleteFacilitatorOwnExprOfIntRule::className()]
                ]
            ]
        ];
    }
}
