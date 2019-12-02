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
use yii\rbac\Permission;

/**
 * Class m180108_112503_partnership_profiles_states_permissions_rule
 */
class m180108_112503_partnership_profiles_states_permissions_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\partnershipprofiles\rules\ReadAllExprOfIntRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permission for (read all) eoi',
                'ruleName' => \lispa\amos\partnershipprofiles\rules\ReadAllExprOfIntRule::className(),
                'parent' => ['VALIDATED_BASIC_USER']
            ]
        ];
    }
}
