<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\partnershipprofiles\rules\ReadAllExprOfIntRule;

/**
 * Class m180118_115929_change_ReadAllExprOfIntRule_parents
 */
class m180118_115929_change_ReadAllExprOfIntRule_parents extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => ReadAllExprOfIntRule::className(),
                'update' => true,
                'newValues' => [
                    'addParents' => ['PARTNERSHIP_PROFILES_ADMINISTRATOR', 'PARTNERSHIP_PROFILES_READER'],
                    'removeParents' => ['VALIDATED_BASIC_USER']
                ]
            ]
        ];
    }
}
