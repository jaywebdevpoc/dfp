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
 * Class m190925_085218_add_permission_document_validate_read
 */
class m190925_085218_add_permission_document_validate_read extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'DOCUMENTI_READ',
                'update' => true,
                'newValues' => [
                    'addParents' => ['DocumentValidate'],
                ]
            ]
        ];
    }
}