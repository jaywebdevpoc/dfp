<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;

/**
 * Class m190109_172216_fix_sondaggi_widgets_permissions
 */
class m190109_172216_fix_sondaggi_widgets_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\sondaggi\widgets\icons\WidgetIconSondaggiGeneral::className(),
                'update' => true,
                'newValues' => [
                    'addParents' => ['AMMINISTRAZIONE_SONDAGGI', 'COMPILATORE_SONDAGGI'],
                    'removeParents' => ['ADMIN', 'BASIC_USER']
                ]
            ]
        ];
    }
}
