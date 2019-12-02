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

/**
 * Class m190116_141125_modify_partnership_profiles_facilitator_permissions
 */
class m190116_141125_modify_partnership_profiles_facilitator_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'PARTNERSHIP_PROFILES_FACILITATOR',
                'update' => true,
                'newValues' => [
                    'addParents' => ['PARTNER_PROF_EXPR_OF_INT_ADMIN_FACILITATOR'],
                    'removeParents' => ['FACILITATOR']
                ]
            ]
        ];
    }
}
