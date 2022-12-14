<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\migrations
 * @category   CategoryName
 */

use lispa\amos\core\exceptions\MigrationsException;
use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\core\migration\libs\common\MigrationCommon;
use lispa\amos\dashboard\models\AmosWidgets;
use lispa\amos\dashboard\utility\DashboardUtility;
use lispa\amos\partnershipprofiles\base\PartnershipProfilesModules;
use lispa\amos\partnershipprofiles\Module;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * Class m180718_140252_fix_partnership_profiles_widgets
 */
class m180718_140252_fix_partnership_profiles_widgets extends AmosMigrationWidgets
{
    /**
     * @var AmosWidgets[] $errorWidgets
     */
    private $errorWidgets = [];

    /**
     * @var array $modules
     */
    private $modules = [];

    /**
     * @throws MigrationsException
     */
    public function init()
    {
        parent::init();

        $this->modules = [
            PartnershipProfilesModules::PART_PROF_MODULE_NAME,
            PartnershipProfilesModules::PART_PROF_ADMIN_MODULE_NAME,
            PartnershipProfilesModules::EXPR_OF_INT_MODULE_NAME,
            PartnershipProfilesModules::EXPR_OF_INT_ADMIN_MODULE_NAME,
            PartnershipProfilesModules::PART_PROF_EXPR_OF_INT_MODULE_NAME
        ];

        foreach ($this->modules as $module) {
            $ok = DashboardUtility::resetDashboardsByModule($module);
            if (!$ok) {
                throw new MigrationsException('Errore durante il reset delle dashboard per il modulo ' . $module);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAddWidgets()
    {
        $this->errorWidgets = $this->findErrorWidget();
        if (count($this->errorWidgets) > 0) {
            MigrationCommon::printConsoleMessage(Module::t('amospartnershipprofiles', 'Cancellazione widget errati'));
            $this->delete(AmosWidgets::tableName(), ['id' => $this->errorWidgets]);
        } else {
            $this->widgets = [];
            MigrationCommon::printConsoleMessage(Module::t('amospartnershipprofiles', 'Nessun widget da modificare'));
        }
        return true;
    }

    private function findErrorWidget()
    {
        $queryError = new Query();
        $queryError->select('id')
            ->from(AmosWidgets::tableName())
            ->andWhere(['like', 'classname', PartnershipProfilesModules::PART_PROF_MODULE_NAME])
            ->andWhere(['module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME])
            ->andWhere(['type' => '']);
        $errorWidgets = $queryError->column();

        $query = new Query();
        $query->select('id')
            ->from(AmosWidgets::tableName())
            ->andWhere(['module' => [
                PartnershipProfilesModules::PART_PROF_ADMIN_MODULE_NAME,
                PartnershipProfilesModules::EXPR_OF_INT_MODULE_NAME,
                PartnershipProfilesModules::PART_PROF_EXPR_OF_INT_MODULE_NAME
            ]]);
        $toModifyWidgets = $query->column();

        $widgets = ArrayHelper::merge($errorWidgets, $toModifyWidgets);
        $widgets = array_unique($widgets);

        return $widgets;
    }

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [

            // Partnership profiles admin widget
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnershipProfilesAllAdmin::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => null,
                'dashboard_visible' => 1,
                'default_order' => 1
            ],

            // Expressions of interest widgets
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestAllAdmin::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => null,
                'dashboard_visible' => 1,
                'default_order' => 1
            ],
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestDashboard::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => null,
                'dashboard_visible' => 1,
                'default_order' => 1
            ],
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestReceived::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestDashboard::className(),
                'dashboard_visible' => 0,
                'default_order' => 10
            ],
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestCreatedBy::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconExpressionsOfInterestDashboard::className(),
                'dashboard_visible' => 0,
                'default_order' => 20
            ],

            // Partnership profiles and expressions of interest widgets
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnerProfExprOfIntDashboard::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => null,
                'dashboard_visible' => 1,
                'default_order' => 1
            ],
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnerProfExprOfIntPartProf::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnerProfExprOfIntDashboard::className(),
                'dashboard_visible' => 0,
                'default_order' => 10
            ],
            [
                'classname' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnerProfExprOfIntExprOfInt::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => PartnershipProfilesModules::PART_PROF_MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\partnershipprofiles\widgets\icons\WidgetIconPartnerProfExprOfIntDashboard::className(),
                'dashboard_visible' => 0,
                'default_order' => 20
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        MigrationCommon::printConsoleMessage('La migration ' . __CLASS__ . ' non pu?? essere revertata');
        return false;
    }
}
