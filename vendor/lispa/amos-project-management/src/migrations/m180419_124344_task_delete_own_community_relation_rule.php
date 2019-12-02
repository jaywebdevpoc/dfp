<?php

use \lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;
use lispa\amos\projectmanagement\rules\TaskOrganizationsMmRule;

class m180419_124344_task_delete_own_community_relation_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {

        return [

            [
                'name' => \lispa\amos\projectmanagement\rules\PmDeleteOwnCommunityRelationRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on exit form your own community',
                'ruleName' => \lispa\amos\projectmanagement\rules\PmDeleteOwnCommunityRelationRule::className(),
                'parent' => ['PROJECT_MANAGER'],
            ],

        ];
    }
}
