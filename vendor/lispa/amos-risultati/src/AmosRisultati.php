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

namespace lispa\amos\risultati;

use lispa\amos\core\module\AmosModule;
use lispa\amos\core\module\ModuleInterface;

/**
 * Class AmosRisultati
 * @package lispa\amos\risultati
 */
class AmosRisultati extends AmosModule implements ModuleInterface
{
    public static $CONFIG_FOLDER = 'config';

    /**
     * @var string|boolean the layout that should be applied for views within this module. This refers to a view name
     * relative to [[layoutPath]]. If this is not set, it means the layout value of the [[module|parent module]]
     * will be taken. If this is false, layout will be disabled within this module.
     */
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'lispa\amos\risultati\controllers';
    public $newFileMode = 0666;
    public $name = 'Risultati';

    /**
     * @return string
     */
    public static function getModuleName()
    {
        return 'risultati';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        \Yii::configure($this, require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php'));
    }

    public function getWidgetGraphics()
    {
        return NULL;
    }

    public function getWidgetIcons()
    {
        return [
            \lispa\amos\risultati\widgets\icons\WidgetIconRisultati::className(),
            \lispa\amos\risultati\widgets\icons\WidgetIconTecnologieRisultati::className(),
            \lispa\amos\risultati\widgets\icons\WidgetIconStadioSviluppoRisultati::className(),
            \lispa\amos\risultati\widgets\icons\WidgetIconProtezioneInnovazioneRisultati::className(),
            \lispa\amos\risultati\widgets\icons\WidgetIconBisognoPerSviluppoRisultati::className(),
        ];
    }

    protected function getDefaultModels()
    {
        return [];
    }
}
