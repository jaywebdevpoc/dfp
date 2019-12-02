<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\projectmanagement\rules\PartnerReferentByCommunityRoleRule;
use lispa\amos\projectmanagement\rules\ProjectManagerByCommunityRoleRule;
use yii\rbac\Permission;

/**
 * Class m170601_104138_add_pm_and_pr_by_community_roles
 */
class m170601_104138_add_pm_and_pr_by_community_roles extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'PM_BY_COMMUNITY_ROLE',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Project manager role by community role',
                'ruleName' => ProjectManagerByCommunityRoleRule::className(),
                'parent' => ['PROJECT_MANAGER']
            ],
            [
                'name' => 'PR_BY_COMMUNITY_ROLE',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Partner referent role by community role',
                'ruleName' => PartnerReferentByCommunityRoleRule::className(),
                'parent' => ['PARTNER_REFERENT']
            ]
        ];
    }
}
