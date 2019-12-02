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
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;
use lispa\amos\partnershipprofiles\rules\PartnershipProfilesDraftStatusRule;
use yii\rbac\Permission;

/**
 * Class m180110_160844_change_partnership_profiles_states_permissions_2
 */
class m180110_160844_change_partnership_profiles_states_permissions_2 extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => PartnershipProfilesDraftStatusRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission to draft a partnership profile',
                'ruleName' => PartnershipProfilesDraftStatusRule::className(),
                'parent' => ['PARTNERSHIP_PROFILES_CREATOR', 'PARTNERSHIP_PROFILES_FACILITATOR'],
                'children' => [PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_DRAFT]
            ],
            [
                'name' => PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_DRAFT,
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PARTNERSHIP_PROFILES_CREATOR']
                ]
            ]
        ];
    }
}
