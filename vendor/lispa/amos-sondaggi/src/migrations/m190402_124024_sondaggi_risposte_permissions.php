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
use yii\rbac\Permission;

/**
 * Class m180911_081424_new_compila_sondaggi_widgets_permissions
 */
class m190402_124024_sondaggi_risposte_permissions extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        $prefixStr = 'Permissions for the dashboard for the widget ';
        return [
            [
                'name' => 'readOwnSondaggiRisposte',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if read sondaggi risposte',
                'ruleName' => \lispa\amos\core\rules\DefaultOwnContentRule::className(),
                'parent' => ['COMPILATORE_SONDAGGI'],
                'children' => ['SONDAGGIRISPOSTE_READ']
            ],
            [
                'name' => 'updateOwnSondaggiRisposte',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if read sondaggi risposte',
                'ruleName' => \lispa\amos\core\rules\DefaultOwnContentRule::className(),
                'parent' => ['COMPILATORE_SONDAGGI'],
                'children' => ['SONDAGGIRISPOSTE_UPDATE']
            ],
            [
                'name' => 'deleteOwnSondaggiRisposte',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if read sondaggi risposte',
                'ruleName' => \lispa\amos\core\rules\DefaultOwnContentRule::className(),
                'parent' => ['COMPILATORE_SONDAGGI'],
                'children' => ['SONDAGGIRISPOSTE_DELETE']
            ],
           [
                'name' => 'SONDAGGIRISPOSTE_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if read sondaggi risposte',
                'parent' => ['AMMINISTRAZIONE_SONDAGGI']
            ],
            [
                'name' => 'SONDAGGIRISPOSTE_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if delete sondaggi risposte',
                'parent' => ['AMMINISTRAZIONE_SONDAGGI']
            ],
            [
                'name' => 'SONDAGGIRISPOSTE_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Check if update sondaggi risposte',
                'parent' => ['AMMINISTRAZIONE_SONDAGGI']
            ],


        ];
    }
}
