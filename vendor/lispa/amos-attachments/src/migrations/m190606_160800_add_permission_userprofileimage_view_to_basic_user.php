<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\admin\migrations
 * @category   CategoryName
 */

use lispa\amos\admin\rules\ValidatedBasicUserRule;
use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m170526_075529_create_basic_user_role
 */
class m190606_160800_add_permission_userprofileimage_view_to_basic_user extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'USERPROFILE_USERPROFILEIMAGE_VIEW',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permit to Basic User that no have _READ permession to SHOW its own icon and others',
                'parent' => ['BASIC_USER']
            ],
        ];
    }
}
