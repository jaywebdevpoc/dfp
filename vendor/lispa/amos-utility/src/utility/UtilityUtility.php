<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\utility\utility
 * @category   CategoryName
 */

namespace lispa\amos\utility\utility;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\core\user\User;
use yii\db\Query;

/**
 * Class UtilityUtility
 * @package lispa\amos\utility\utility
 */
class UtilityUtility
{
    /**
     * This method returns an array indexed by user ids and the values are name and surname.
     * The users are active and not deleted.
     * @return array
     */
    public static function getUsersToImpersonate()
    {
        $userProfileTable = UserProfile::tableName();
        $userTable = User::tableName();
        $query = new Query();
        $query->select(["CONCAT(" . $userProfileTable . ".nome, ' ', " . $userProfileTable . ".cognome, ' - userId: ', " . $userProfileTable . ".user_id, ' - userProfileId: ', " . $userProfileTable . ".id) AS userNameSurname"]);
        $query->from($userTable);
        $query->innerJoin($userProfileTable, $userProfileTable . '.user_id = ' . $userTable . '.id');
        $query->andWhere([$userTable . '.deleted_at' => null]);
        $query->andWhere([$userProfileTable . '.deleted_at' => null]);
        $query->andWhere([$userTable . '.status' => User::STATUS_ACTIVE]);
        $query->andWhere([$userProfileTable . '.attivo' => UserProfile::STATUS_ACTIVE]);
        $query->andWhere(['not like', 'email', '#deleted_']);
        $query->andWhere(['<>', $userTable . '.id', \Yii::$app->user->id]);
        $query->indexBy('id');
        $usersToImpersonate = $query->column();
        return $usersToImpersonate;
    }
}
