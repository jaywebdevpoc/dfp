<?php

use yii\db\Migration;

/**
 * Class m180205_141159_add_project_manager_role_to_all_validated_basic_user
 */
class m180205_141159_add_project_manager_role_to_all_validated_basic_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\rbac\Role $projectManagerRole */
        $projectManagerRole = Yii::$app->authManager->getRole('PROJECT_MANAGER');
        /** @var \yii\rbac\Role $validatedBasicUser */
        $validatedBasicUser = Yii::$app->authManager->getRole('VALIDATED_BASIC_USER');
        if (!is_null($projectManagerRole) && !is_null($validatedBasicUser) && Yii::$app->authManager->canAddChild($validatedBasicUser,$projectManagerRole)) {
            if (!Yii::$app->authManager->hasChild($validatedBasicUser,$projectManagerRole)) {
                Yii::$app->authManager->addChild($validatedBasicUser, $projectManagerRole);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // A FIX... NO SAFE DOWN...
        return true;
    }

}
