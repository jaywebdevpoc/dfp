<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\notify\migrations
 * @category   CategoryName
 */

use lispa\amos\notificationmanager\utility\NotifyUtility;
use yii\db\Migration;

/**
 * Class m190902_155031_insert_missing_user_notifications_confs
 */
class m190902_155031_insert_missing_user_notifications_confs extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $notifyUtility = new NotifyUtility();
        $ok = $notifyUtility->addMissingUserNotificationsConfs();
        return $ok;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m190902_155031_insert_missing_user_notifications_confs cannot be reverted.\n";
        return false;
    }
}
