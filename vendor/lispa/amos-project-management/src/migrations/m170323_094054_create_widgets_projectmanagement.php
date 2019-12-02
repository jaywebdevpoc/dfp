<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\migrations
 * @category   CategoryName
 */

use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;
use yii\db\Query;

/**
 * Class m170323_094054_create_widgets_projectmanagement
 */
class m170323_094054_create_widgets_projectmanagement extends AmosMigrationWidgets
{
    const MODULE_NAME = 'project_management';

    /**
     * @var string $migrationTable
     */
    private $migrationTable = '{{%migration}}';

    /**
     * @var string $oldMigrationName
     */
    private $oldMigrationName = 'm170323_093754_create_widgets_projectmanagement';

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
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED
            ],
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconprojects::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()
            ],
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconMyProjects::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()
            ],
            [
                'classname' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconCreatedByProjects::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\projectmanagement\widgets\icons\WidgetIconProjectManagement::className()
            ]
        ];
    }
}
