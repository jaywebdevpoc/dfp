<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\documenti\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m190930_105218_add_permission_discussion_validate_read
 */
class m190930_105218_add_permission_discussion_validate_read extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'DISCUSSIONITOPIC_READ',
                'update' => true,
                'newValues' => [
                    'addParents' => ['DiscussionValidate'],
                ]
            ]
        ];
    }
}