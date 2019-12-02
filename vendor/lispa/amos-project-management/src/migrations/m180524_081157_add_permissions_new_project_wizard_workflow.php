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

/**
 * Class m180524_081157_add_permissions_new_project_wizard_workflow
 */
class m180524_081157_add_permissions_new_project_wizard_workflow extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepA::WIZFLOW,
                'update' => true,
                'newValues' => [
                    'addParents' => ['ADMIN']
                ]
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepB::WIZFLOW,
                'update' => true,
                'newValues' => [
                    'addParents' => ['ADMIN']
                ]
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepC::WIZFLOW,
                'update' => true,
                'newValues' => [
                    'addParents' => ['ADMIN']
                ]
            ],
            [
                'name' => \lispa\amos\projectmanagement\models\new_project_wizard\StepD::WIZFLOW,
                'update' => true,
                'newValues' => [
                    'addParents' => ['ADMIN']
                ]
            ]
        ];
    }
}
