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
 * Class m170605_124914_remove_partner_referent_from_project_manager
 */
class m170605_124914_remove_partner_referent_from_project_manager extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'PARTNER_REFERENT',
                'update' => true,
                'newValues' => [
                    'removeParents' => ['PROJECT_MANAGER']
                ]
            ]
        ];
    }
}
