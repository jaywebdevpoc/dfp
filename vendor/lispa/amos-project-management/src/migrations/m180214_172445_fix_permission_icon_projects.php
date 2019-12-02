<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconprojects;

/**
 * Class m180214_172445_fix_permission_icon_projects
 */
class m180214_172445_fix_permission_icon_projects extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        /** @var \yii\rbac\Role $projectManagerRole */
        $projectManagerRole = Yii::$app->authManager->getRole('PROJECT_MANAGER');
        /** @var \yii\rbac\Role $validatedBasicUser */
        $permission = Yii::$app->authManager->getPermission(WidgetIconprojects::className());
        if (!is_null($projectManagerRole) && !is_null($permission) && Yii::$app->authManager->canAddChild($projectManagerRole, $permission)) {
            if (!Yii::$app->authManager->hasChild($projectManagerRole,$permission)) {
                Yii::$app->authManager->addChild($projectManagerRole,$permission);
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
