<?php

use yii\db\Migration;

/**
 * Class m180221_133359_add_rule_comments_to_projects_modify_request
 */
class m180221_133359_add_rule_comments_to_projects_modify_request extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\rules\ProjectsModifyRequestCommentsRule::className(),
                'type' => \yii\rbac\Permission::TYPE_ROLE,
                'description' => 'Regola CommentsContributorRule',
                'ruleName' => \lispa\amos\projectmanagement\rules\ProjectsModifyRequestCommentsRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER'],
                'children' => ['COMMENTS_CONTRIBUTOR']
            ],
        ];
    }

}
