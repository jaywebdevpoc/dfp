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

namespace lispa\amos\risultati\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\risultati\AmosRisultati;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconRisultatiDashboard
 * @package lispa\amos\risultati\widgets\icons
 */
class WidgetIconRisultatiDashboard extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(static::widgetLabel());
        $this->setDescription(AmosRisultati::t('amosrisultati', 'Modulo risultati'));
        $this->setIcon('linentita');
        $this->setUrl(['/risultati']);
        $this->setCode('RISULTATI_MODULE');
        $this->setModuleName('risultati-dashboard');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-secondary'
        ]));
    }

    public static function widgetLabel()
    {
        return AmosRisultati::t('amosrisultati', 'Dashboard risultati');
    }

    /* TEMPORANEA */

    public function getOptions()
    {
        $options = parent::getOptions();

        //aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
        return ArrayHelper::merge($options, ["children" => $this->getWidgetsIcon()]);
    }

    public function getWidgetsIcon()
    {
        $widgets = [];

        $WidgetIconNewsCategorie = new WidgetIconRisultati();
        if ($WidgetIconNewsCategorie->isVisible()) {
            $widgets[] = $WidgetIconNewsCategorie->getOptions();
        }

        $WidgetIconNewsCreatedBy = new WidgetIconProtezioneInnovazioneRisultati();
        if ($WidgetIconNewsCreatedBy->isVisible()) {
            $widgets[] = $WidgetIconNewsCreatedBy->getOptions();
        }

        $WidgetIconNewsCreatedBy = new WidgetIconBisognoPerSviluppoRisultati();
        if ($WidgetIconNewsCreatedBy->isVisible()) {
            $widgets[] = $WidgetIconNewsCreatedBy->getOptions();
        }

        $WidgetIconNewsCreatedBy = new WidgetIconStadioSviluppoRisultati();
        if ($WidgetIconNewsCreatedBy->isVisible()) {
            $widgets[] = $WidgetIconNewsCreatedBy->getOptions();
        }

        $WidgetIconNewsCreatedBy = new WidgetIconTecnologieRisultati();
        if ($WidgetIconNewsCreatedBy->isVisible()) {
            $widgets[] = $WidgetIconNewsCreatedBy->getOptions();
        }

        return $widgets;
    }
}
