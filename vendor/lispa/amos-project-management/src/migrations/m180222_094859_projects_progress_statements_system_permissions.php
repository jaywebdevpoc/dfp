<?php

use lispa\amos\core\migration\AmosMigrationPermissions;
use lispa\amos\projectmanagement\rules\ProjectsProgressStatementsCreateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressStatementsUpdateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressStatementsReadRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressStatementsDeleteRule;

use lispa\amos\projectmanagement\rules\ProjectsProgressDetectionPeriodDeleteRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressDetectionPeriodCreateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressDetectionPeriodUpdateRule;
use lispa\amos\projectmanagement\rules\ProjectsProgressDetectionPeriodReadRule;

use yii\rbac\Permission;


/**
 * Class m180222_094859_projects_progress_statements_system_permissions
 */
class m180222_094859_projects_progress_statements_system_permissions extends AmosMigrationPermissions
{

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {

        return [

            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Role manager progress detection period',
                'parent' => ['PROJECT_MANAGER'],
                'children' => ['COMMENTS_CONTRIBUTOR']
            ],

            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_READER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Role reader progress detection period',
                'parent' => ['PROJECT_MANAGER']
            ],

            [
                'name' => 'PROJECTSPROGRESSSTATEMENTS_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Role manager progress detection period',
                'parent' => ['PROJECT_MANAGER']
            ],

            [
                'name' => ProjectsProgressStatementsCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on create projectsProgressStatements',
                'ruleName' => ProjectsProgressStatementsCreateRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSSTATEMENTS_CREATE']
            ],

            [
                'name' => ProjectsProgressStatementsUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on update projectsProgressStatements',
                'ruleName' => ProjectsProgressStatementsUpdateRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSSTATEMENTS_UPDATE']
            ],

            [
                'name' => ProjectsProgressStatementsReadRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on read projectsProgressStatements',
                'ruleName' => ProjectsProgressStatementsReadRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSSTATEMENTS_READ']
            ],

            [
                'name' => ProjectsProgressStatementsDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on read projectsProgressStatements',
                'ruleName' => ProjectsProgressStatementsDeleteRule::className(),
                'parent' => ['PROJECTSPROGRESSSTATEMENTS_MANAGER'],
                'children' => ['PROJECTSPROGRESSSTATEMENTS_DELETE']
            ],

            [
                'name' => 'PROJECTSPROGRESSSTATEMENTS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model ',
            ],
            [
                'name' => 'PROJECTSPROGRESSSTATEMENTS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model ProjectsProgressStatements',
            ],
            [
                'name' => 'PROJECTSPROGRESSSTATEMENTS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model ProjectsProgressStatements',
            ],
            [
                'name' => 'PROJECTSPROGRESSSTATEMENTS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model ProjectsProgressStatements',
            ],

            [
                'name' => ProjectsProgressDetectionPeriodDeleteRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on delete progressDetectionPeriod',
                'ruleName' => ProjectsProgressDetectionPeriodDeleteRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => ['PROJECTSPROGRESSDETECTIONPERIOD_DELETE']
            ],

            [
                'name' => ProjectsProgressDetectionPeriodCreateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on create progressDetectionPeriod',
                'ruleName' => ProjectsProgressDetectionPeriodCreateRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => ['PROJECTSPROGRESSDETECTIONPERIOD_CREATE']
            ],

            [
                'name' => ProjectsProgressDetectionPeriodUpdateRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on update progressDetectionPeriod',
                'ruleName' => ProjectsProgressDetectionPeriodUpdateRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER'],
                'children' => ['PROJECTSPROGRESSDETECTIONPERIOD_UPDATE']
            ],

            [
                'name' => ProjectsProgressDetectionPeriodReadRule::className(),
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Rule on read progressDetectionPeriod',
                'ruleName' => ProjectsProgressDetectionPeriodReadRule::className(),
                'parent' => ['PROJECTSPROGRESSDETECTIONPERIOD_MANAGER', 'PROJECTSPROGRESSDETECTIONPERIOD_READER'],
                'children' => ['PROJECTSPROGRESSDETECTIONPERIOD_READ']
            ],

            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di CREATE sul model ProjectsProgressDetectionPeriod',
            ],
            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di READ sul model ProjectsProgressDetectionPeriod',
            ],
            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di UPDATE sul model ProjectsProgressDetectionPeriod',
            ],
            [
                'name' => 'PROJECTSPROGRESSDETECTIONPERIOD_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di DELETE sul model ProjectsProgressDetectionPeriod',
            ],

        ];
    }
}


//            [
//                'name' => 'PROJECTSPROGRESSSTATEMENTSTYPE_CREATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di CREATE sul model ProjectsProgressStatementsType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSSTATEMENTSTYPE_READ',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di READ sul model ProjectsProgressStatementsType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSSTATEMENTSTYPE_UPDATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di UPDATE sul model ProjectsProgressStatementsType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSSTATEMENTSTYPE_DELETE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di DELETE sul model ProjectsProgressStatementsType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],

//            [
//                'name' => 'PROJECTSPROGRESSDETECTIONTYPE_CREATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di CREATE sul model ProjectsProgressDetectionType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSDETECTIONTYPE_READ',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di READ sul model ProjectsProgressDetectionType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSDETECTIONTYPE_UPDATE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di UPDATE sul model ProjectsProgressDetectionType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
//            [
//                'name' => 'PROJECTSPROGRESSDETECTIONTYPE_DELETE',
//                'type' => Permission::TYPE_PERMISSION,
//                'description' => 'Permesso di DELETE sul model ProjectsProgressDetectionType',
//                'ruleName' => null,
//                'parent' => ['ADMIN']
//            ],
