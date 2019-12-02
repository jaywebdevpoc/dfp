<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;

/**
 * Class m190605_000222_permissions_events_checkin_rule
 */
class m190605_000222_permissions_events_checkin_rule extends AmosMigrationPermissions
{
    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [
            [
                'name' => \lispa\amos\events\rules\EventsCheckInRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di effettuare il checkin negli eventi',
                'ruleName' => \lispa\amos\events\rules\EventsCheckInRule::className(),
                'parent' => ['EVENTS_READER', 'EVENT_READ']
            ],
        ];
    }
}
