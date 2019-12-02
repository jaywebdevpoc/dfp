<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationPermissions;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\rbac\Permission;

/**
 * Class m170323_093853_init_progetto_project_management
 */
class m170323_093853_init_progetto_project_management extends AmosMigrationPermissions
{
    /**
     * @var string $migrationTable
     */
    private $migrationTable = '{{%migration}}';

    /**
     * @var string $oldMigrationName
     */
    private $oldMigrationName = 'm170323_093753_init_progetto_project_management';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $query = new Query();
        $query->from($this->migrationTable);
        $query->andWhere(['like', 'version', $this->oldMigrationName]);
        $exists = $query->exists();
        if ($exists) {
            $this->delete($this->migrationTable, ['version' => $this->oldMigrationName]);
            return true;
        } else {
            return parent::safeUp();
        }
    }

    /**
     * @inheritdoc
     */
    protected function setRBACConfigurations()
    {
        return ArrayHelper::merge(
            $this->setPluginRoles(),
            $this->setModelPermissions()
        );
    }

    private function setPluginRoles()
    {
        return [
            [
                'name' => 'PROJECT_MANAGER',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Ruolo PROJECT MANAGER',
                'parent' => ['ADMIN']
            ],
            [
                'name' => 'PARTNER_REFERENT',
                'type' => Permission::TYPE_ROLE,
                'description' => 'Ruolo PARTNER_REFERENT',
                'parent' => ['PROJECT_MANAGER']
            ],
        ];
    }

    private function setModelPermissions()
    {
        return [

            // Permissions for model Projects
            [
                'name' => 'PROJECTS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model Projects',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model Projects',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model Projects',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model Projects',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],

            // Permissions for model ProjectsStates
            [
                'name' => 'PROJECTSSTATES_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model ProjectsStates',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSSTATES_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model ProjectsStates',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTSSTATES_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model ProjectsStates',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSSTATES_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model ProjectsStates',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],

            // Permissions for model ProjectsMeasure
            [
                'name' => 'PROJECTSMEASURE_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model ProjectsMeasure',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSMEASURE_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model ProjectsMeasure',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTSMEASURE_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model ProjectsMeasure',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSMEASURE_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model ProjectsMeasure',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],

            // Permissions for model ProjectsActivities
            [
                'name' => 'PROJECTSACTIVITIES_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model ProjectsActivities',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSACTIVITIES_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model ProjectsActivities',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTSACTIVITIES_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model ProjectsActivities',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSACTIVITIES_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model ProjectsActivities',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],

            // Permissions for model ProjectsTasks
            [
                'name' => 'PROJECTSTASKS_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model ProjectsTasks',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSTASKS_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model ProjectsTasks',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTSTASKS_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model ProjectsTasks',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSTASKS_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model ProjectsTasks',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],

            // Permissions for model ProjectsTaskStatuses
            [
                'name' => 'PROJECTSTASKSTATUSES_CREATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di create sul model ProjectsTaskStatuses',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSTASKSTATUSES_READ',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di read sul model ProjectsTaskStatuses',
                'parent' => ['ADMIN', 'PARTNER_REFERENT']
            ],
            [
                'name' => 'PROJECTSTASKSTATUSES_UPDATE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di update sul model ProjectsTaskStatuses',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ],
            [
                'name' => 'PROJECTSTASKSTATUSES_DELETE',
                'type' => Permission::TYPE_PERMISSION,
                'description' => 'Permesso di delete sul model ProjectsTaskStatuses',
                'parent' => ['ADMIN', 'PROJECT_MANAGER']
            ]
        ];
    }
}
