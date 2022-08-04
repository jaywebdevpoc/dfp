<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\migration\AmosMigrationWidgets;
use lispa\amos\dashboard\models\AmosWidgets;

/**
 * Class m161221_085238_add_init_risultati_widgets
 */
class m161221_085238_add_init_risultati_widgets extends AmosMigrationWidgets
{
    const MODULE_NAME = 'risultati';

    /**
     * @inheritdoc
     */
    protected function initWidgetsConfs()
    {
        $this->widgets = [
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED
            ],
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultati::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className()
            ],
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconBisognoPerSviluppoRisultati::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className()
            ],
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconProtezioneInnovazioneRisultati::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className()
            ],
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconStadioSviluppoRisultati::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className()
            ],
            [
                'classname' => \lispa\amos\risultati\widgets\icons\WidgetIconTecnologieRisultati::className(),
                'type' => AmosWidgets::TYPE_ICON,
                'module' => self::MODULE_NAME,
                'status' => AmosWidgets::STATUS_ENABLED,
                'child_of' => \lispa\amos\risultati\widgets\icons\WidgetIconRisultatiDashboard::className()
            ]
        ];
    }
}
