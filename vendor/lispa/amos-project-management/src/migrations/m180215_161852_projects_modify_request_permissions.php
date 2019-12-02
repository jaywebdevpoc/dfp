<?php

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\rbac\Permission;


/**
 * Class m180215_161852_projects_modify_request_permissions*/
class m180215_161852_projects_modify_request_permissions extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return [

            [
                'name' => 'PROJECTS_MODIFY_REQUEST_MANAGER',
                'type' => \yii\rbac\Permission::TYPE_ROLE,
                'description' => 'Role of projects - modify request manager',
                'parent' => ['PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTS_MODIFY_REQUEST_MODIFIER',
                'type' => \yii\rbac\Permission::TYPE_ROLE,
                'description' => 'Role of projects - modify request modifier',
                'parent' => ['PROJECTS_MODIFY_REQUEST_MANAGER']
            ],
            [
                'name' => 'PROJECTS_MODIFY_REQUEST_READER',
                'type' => \yii\rbac\Permission::TYPE_ROLE,
                'description' => 'Role of projects - modify request reader',
                'parent' => ['PROJECTS_MODIFY_REQUEST_MANAGER']
            ],

            [
                'name' => 'ProjectsModifyRequestCreateRule',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso',
                'ruleName' => \lispa\amos\projectmanagement\rules\ProjectsModifyRequestCreateRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER']
            ],
            [
                'name' => 'ProjectsModifyRequestUpdateRule',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso',
                'ruleName' => \lispa\amos\projectmanagement\rules\ProjectsModifyRequestUpdateRule::className(),
                'parent' => ['PROJECTS_MODIFY_REQUEST_MODIFIER']
            ],

            [
                'name' => 'PROJECTSMODIFYREQUEST_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model ProjectsModifyRequest',
                'ruleName' => null,
                'parent' => ['ProjectsModifyRequestCreateRule']
            ],
            [
                'name' => 'PROJECTSMODIFYREQUEST_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model ProjectsModifyRequest',
                'ruleName' => null,
                'parent' => ['PROJECTS_MODIFY_REQUEST_READER']
            ],
            [
                'name' => 'PROJECTSMODIFYREQUEST_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model ProjectsModifyRequest',
                'ruleName' => null,
                'parent' => ['ProjectsModifyRequestUpdateRule']
            ],
            [
                'name' => 'PROJECTSMODIFYREQUEST_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model ProjectsModifyRequest',
                'ruleName' => null,
                'parent' => ['ProjectsModifyRequestUpdateRule']
            ],


//            [
//                'name' => 'PROJECTSATMODIFYREQUESTMM_CREATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di CREATE sul model ProjectsAtModifyRequestMm',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSATMODIFYREQUESTMM_READ',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di READ sul model ProjectsAtModifyRequestMm',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSATMODIFYREQUESTMM_UPDATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di UPDATE sul model ProjectsAtModifyRequestMm',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSATMODIFYREQUESTMM_DELETE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di DELETE sul model ProjectsAtModifyRequestMm',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],


        ];
    }
}
