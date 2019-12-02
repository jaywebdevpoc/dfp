<?php

use yii\db\Migration;

class m180314_154115_permission_new_project_wizard_workflow extends \lispa\amos\core\migration\AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepA::WIZFLOW,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permission step workflow',
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepB::WIZFLOW,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permission step workflow',
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepC::WIZFLOW,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permission step workflow',
                'parent' => ['PARTNER_REFERENT']
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepD::WIZFLOW,
                'type' => \yii\rbac\Permission::TYPE_PERMISSION,
                'description' => 'Permission step workflow',
                'parent' => ['PARTNER_REFERENT']
            ],
        ];
    }
}
