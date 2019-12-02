<?php

use yii\db\Migration;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconMyProjects;

/**
 * Class m180306_163804_remove_permission_widget_my_projects
 */
class m180306_163804_remove_permission_widget_my_projects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /** @var \yii\rbac\Role $rolePM */
        $rolePM = Yii::$app->authManager->getRole('PROJECT_MANAGER');
        /** @var \yii\rbac\Permission $permWidget */
        $permWidget = Yii::$app->authManager->getPermission(WidgetIconMyProjects::className());
        if (!empty($rolePM) && !empty($permWidget)) {
            Yii::$app->authManager->removeChild($rolePM, $permWidget);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /** @var \yii\rbac\Role $rolePM */
        $rolePM = Yii::$app->authManager->getRole('PROJECT_MANAGER');
        /** @var \yii\rbac\Permission $permWidget */
        $permWidget = Yii::$app->authManager->getPermission(WidgetIconMyProjects::className());
        if (!empty($rolePM) && !empty($permWidget)) {
            Yii::$app->authManager->addChild($rolePM, $permWidget);
        }
    }

}
