<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\news\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m190222_111128_eventsmanager_community_manager_rule
 */
class m190222_111128_eventsmanager_community_manager_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\core\rules\BasicCommunityManagerRoleRule::className(),
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Regola per gestire eventi se sei CM',
                'ruleName' => \lispa\amos\core\rules\BasicCommunityManagerRoleRule::className(),
                'parent' => ['VALIDATED_BASIC_USER'],
                'children' => ['EVENT_MANAGER']
            ]
        ];
    }
}
