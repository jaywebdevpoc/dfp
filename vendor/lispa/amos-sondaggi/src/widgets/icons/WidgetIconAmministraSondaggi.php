<?php

namespace lispa\amos\sondaggi\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\sondaggi\AmosSondaggi;
use Yii;
use yii\helpers\ArrayHelper;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\widget\WidgetAbstract;

/**
 * Class WidgetIconAmministraSondaggi
 * @deprecated since version 1.3.4 for wrong namespace
 * @package lispa\amos\sondaggi\widgets
 */
class WidgetIconAmministraSondaggi extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLabel(AmosSondaggi::tHtml('amossondaggi', 'Amministra i Sondaggi'));
        $this->setDescription(AmosSondaggi::t('amossondaggi', 'Modulo di amministrazione dei Sondaggi'));

        if (!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('sondaggi');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('quote-right');
        }

        $this->setUrl(Yii::$app->urlManager->createUrl(['sondaggi']));
        $this->setCode('AMM_SONDAGGI');
        $this->setModuleName('sondaggi');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                [
                    'bk-backgroundIcon',
                    'color-primary'
                ]
            )
        );
    }

    /**
     * Aggiunge all'oggetto container tutti i widgets recuperati dal controller del modulo
     * 
     * @inheritdoc
     */
    public function getOptions()
    {
        return ArrayHelper::merge(
            parent::getOptions(),
            ['children' => $this->getWidgetsIcon()]
        );
    }

    /**
     * TEMPORANEA
     * @return type
     */
    public function getWidgetsIcon()
    {
        $widgets = [];

        $WidgetIconSondaggi = new icons\WidgetIconSondaggi();
        if ($WidgetIconSondaggi->isVisible()) {
            $widgets[] = $WidgetIconSondaggi->getOptions();
        }

        $WidgetIconCompilaSondaggi = new icons\WidgetIconCompilaSondaggi();
        if ($WidgetIconCompilaSondaggi->isVisible()) {
            $widgets[] = $WidgetIconCompilaSondaggi->getOptions();
        }

        $WidgetIconPubblicaSondaggi = new icons\WidgetIconPubblicaSondaggi();
        if ($WidgetIconPubblicaSondaggi->isVisible()) {
            $widgets[] = $WidgetIconPubblicaSondaggi->getOptions();
        }

        return $widgets;
    }

}
