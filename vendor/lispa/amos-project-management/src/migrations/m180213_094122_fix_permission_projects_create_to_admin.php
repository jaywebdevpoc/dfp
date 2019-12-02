<?php

use yii\db\Migration;

/**
 * Class m180213_094122_fix_permission_projects_create_to_admin
 */
class m180213_094122_fix_permission_projects_create_to_admin extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\rbac\Permission $projectsCreate */
        $projectsCreate = Yii::$app->authManager->getPermission('PROJECTS_CREATE');
        /** @var \yii\rbac\Role $admin */
        $admin = Yii::$app->authManager->getRole('ADMIN');
        if (!is_null($projectsCreate) && !is_null($admin) && Yii::$app->authManager->hasChild($admin, $projectsCreate)) {
            Yii::$app->authManager->removeChild($admin, $projectsCreate);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // FIX no safe down
        return false;
    }

}
