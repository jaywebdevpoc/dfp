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

/**
 * Class m171128_164059_add_basic_user_expressions_of_interest_permissions_1
 */
class m171128_164059_add_basic_user_expressions_of_interest_permissions_1 extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => 'EXPRESSIONS_OF_INTEREST_READER',
                'update' => true,
                'newValues' => [
                    'addParents' => ['VALIDATED_BASIC_USER']
                ]
            ],
            [
                'name' => 'EXPRESSIONS_OF_INTEREST_CREATOR',
                'update' => true,
                'newValues' => [
                    'addParents' => ['VALIDATED_BASIC_USER']
                ]
            ],
            [
                'name' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestCreatedBy::className(),
                'update' => true,
                'newValues' => [
                    'removeParents' => ['EXPRESSIONS_OF_INTEREST_READER'],
                    'addParents' => ['EXPRESSIONS_OF_INTEREST_CREATOR']
                ]
            ]
        ];
    }
}
