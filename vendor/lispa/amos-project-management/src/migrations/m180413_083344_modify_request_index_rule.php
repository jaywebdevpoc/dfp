<?php

use \lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;
use lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule;

class m180413_083344_modify_request_index_rule extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {

        return [

            [
                'name' => ProjectsModifyRequestIndexRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on index of ProjectsModifyRequestIndex',
                'ruleName' => ProjectsModifyRequestIndexRule::className(),
                'parent' => ['PROJECT_MANAGER'],
                //'children' => ['PROJECTSPROGRESSSTATEMENTS_CREATE']
            ],

        ];
    }
}
