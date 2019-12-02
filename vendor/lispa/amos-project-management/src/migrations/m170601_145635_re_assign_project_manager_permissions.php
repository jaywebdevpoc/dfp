<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\libs\common\MigrationCommon;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconMyProjects;
use lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement;
use yii\db\Migration;
use yii\rbac\DbManager;
use yii\rbac\Item;

/**
 * Class m170601_145635_re_assign_project_manager_permissions
 */
class m170601_145635_re_assign_project_manager_permissions extends Migration
{
    /**
     * @var DbManager $authManager
     */
    private $authManager = null;

    private $toSkipChildren = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->authManager = Yii::$app->getAuthManager();
        $this->toSkipChildren = [
            'PROJECTS_CREATE',
            'PROJECTS_READ',
            'PROJECTSSTATES_READ',
            'PROJECTSMEASURE_READ',
            'PROJECTSACTIVITIES_READ',
            'PROJECTSTASKS_READ',
            'PROJECTSTASKSTATUSES_READ',
            'PM_BY_COMMUNITY_ROLE',
            'PARTNER_REFERENT',
            WidgetIconCreatedByProjects::className(),
            WidgetIconMyProjects::className(),
            WidgetIconProjectManagement::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $ok = $this->switchChildrenBetweenRoles('PROJECT_MANAGER', 'PM_BY_COMMUNITY_ROLE', $this->toSkipChildren);
        if ($ok) {
            $toCopy = [
                'PROJECTS_READ',
                'PROJECTSSTATES_READ',
                'PROJECTSMEASURE_READ',
                'PROJECTSACTIVITIES_READ',
                'PROJECTSTASKS_READ',
                'PROJECTSTASKSTATUSES_READ',
                WidgetIconCreatedByProjects::className(),
                WidgetIconMyProjects::className(),
                WidgetIconProjectManagement::className()
            ];
            $toSkip = array_diff($this->toSkipChildren, $toCopy);
            $ok = $this->switchChildrenBetweenRoles('PR_BY_COMMUNITY_ROLE', 'PROJECT_MANAGER', $toSkip, false);
        }
        return $ok;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        return $this->switchChildrenBetweenRoles('PM_BY_COMMUNITY_ROLE', 'PROJECT_MANAGER', $this->toSkipChildren);
    }

    /**
     * This method take all children permissions or roles of one role, remove
     * all from it and add all permissions and roles to one another role.
     * @param string $fromRole
     * @param string $toRole
     * @param string[] $toSkipChildren
     * @return bool
     */
    protected function switchChildrenBetweenRoles($fromRole, $toRole, $toSkipChildren = [], $removeChildren = true)
    {
        $startRole = $this->findRole($fromRole);
        $endRole = $this->findRole($toRole);
        if (is_null($startRole) || is_null($endRole)) {
            return false;
        }

        $ok = true;
        $children = $this->authManager->getChildren($fromRole);
        foreach ($children as $child) {
            if (in_array($child->name, $toSkipChildren)) {
                MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                    "AuthItem da skippare: " . $child->name));
                continue;
            }
            if (!$this->moveChild($child, $startRole, $endRole, $removeChildren)) {
                break;
            }
        }
        return $ok;
    }

    /**
     * @param Item $child
     * @param Item $startRole
     * @param Item $endRole
     * @return bool
     */
    private function moveChild($child, $startRole, $endRole, $removeChildren = true)
    {
        $ok = true;
        if ($removeChildren) {
            $ok = $this->authManager->removeChild($startRole, $child);
        }
        if ($ok) {
            if (!$this->authManager->hasChild($endRole, $child)) {
                if ($child->name != $endRole->name) {
                    $ok = $this->authManager->addChild($endRole, $child);
                    if ($ok) {
                        MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                            "AuthItem '" . $child->name . "' assegnato correttamente a '" . $endRole->name . "'"));
                    } else {
                        MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                            "Errori durante l'assegnazione di '" . $child->name . "' a '" . $endRole->name . "'"));
                    }
                } else {
                    MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                        "AuthItem da assegnare '" . $child->name . "' uguale al ruolo finale. Assegnazione non possibile."));
                }
            } else {
                MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                    "Il ruolo '" . $endRole->name . "' ha già il figlio '" . $child->name . "'"));
            }
        } else {
            MigrationCommon::printConsoleMessage(Module::t('amosproject_management',
                "Errori durante la rimozione di '" . $child->name . "' da '" . $endRole->name . "'"));
        }
        return $ok;
    }

    /**
     * @param string $roleName
     * @return null|\yii\rbac\Role
     */
    private function findRole($roleName)
    {
        $role = Yii::$app->getAuthManager()->getRole($roleName);
        if (is_null($role)) {
            MigrationCommon::printConsoleMessage(Module::t('amosproject_management', "Ruolo '$roleName' non trovato"));
        }
        return $role;
    }
}
