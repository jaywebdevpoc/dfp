<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use yii\db\Migration;

/**
 * Class m170601_131542_projects_partner_referent_role_fix
 */
class m170601_131542_projects_partner_referent_role_fix extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\rbac\ManagerInterface $authManager */
        $authManager = \Yii::$app->getAuthManager();
        $prRole = $authManager->getRole('PARTNER_REFERENT');

        if (empty($prRole)) {
            echo "PARTNER_REFERENT role does not exist.";
            return false;
        }

        $prByCommunityRole = $authManager->getRole('PR_BY_COMMUNITY_ROLE');
        if (empty($prByCommunityRole)) {
            echo "PR_BY_COMMUNITY_ROLE role does not exist.";
            return false;
        }

        $authItems = $authManager->getChildren('PARTNER_REFERENT');
        if (empty($authItems)) {
            echo "PARTNER_REFERENT role has no children.";
            return false;
        }

        /** @var \yii\rbac\Item $authItem */
        foreach ($authItems as $authItem) {
            if ($authItem->name != 'PR_BY_COMMUNITY_ROLE') {
                if (!$authManager->removeChild($prRole, $authItem)) {
                    echo "Error while removing " . $authItem->name . " from role PARTNER_REFERENT.";
                    return false;
                }
                if (!$authManager->hasChild($prByCommunityRole, $authItem)) {
                    if (!$authManager->addChild($prByCommunityRole, $authItem)) {
                        echo "Error while adding " . $authItem->name . " to role PR_BY_COMMUNITY_ROLE.";
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        /** @var \yii\rbac\ManagerInterface $authManager */
        $authManager = \Yii::$app->getAuthManager();
        $prRole = $authManager->getRole('PARTNER_REFERENT');

        if (empty($prRole)) {
            echo "PARTNER_REFERENT role does not exist.";
            return false;
        }

        $prByCommunityRole = $authManager->getRole('PR_BY_COMMUNITY_ROLE');
        if (empty($prByCommunityRole)) {
            echo "PR_BY_COMMUNITY_ROLE role does not exist.";
            return false;
        }

        $authItems = $authManager->getChildren('PR_BY_COMMUNITY_ROLE');
        if (empty($authItems)) {
            echo "PR_BY_COMMUNITY_ROLE role has no children.";
            return false;
        }

        /** @var \yii\rbac\Item $authItem */
        foreach ($authItems as $authItem) {
            if (!$authManager->removeChild($prByCommunityRole, $authItem)) {
                echo "Error while removing " . $authItem->name . " from role PR_BY_COMMUNITY_ROLE.";
                return false;
            }
            if (!$authManager->hasChild($prRole, $authItem)) {
                if (!$authManager->addChild($prRole, $authItem)) {
                    echo "Error while adding " . $authItem->name . " to role PARTNER_REFERENT.";
                    return false;
                }
            }
        }

        return true;
    }
}
