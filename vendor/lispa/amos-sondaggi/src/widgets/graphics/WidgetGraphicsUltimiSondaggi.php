<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\news\widgets\graphics
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\widgets\graphics;

use lispa\amos\core\widget\WidgetGraphic;
use lispa\amos\sondaggi\AmosSondaggi;
use lispa\amos\sondaggi\models\search\SondaggiSearch;
use lispa\amos\notificationmanager\base\NotifyWidgetDoNothing;
use lispa\amos\core\widget\WidgetAbstract;

class WidgetGraphicsUltimiSondaggi extends WidgetGraphic {

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        $this->setCode('ULTIMI_SONDAGGI_GRAPHIC');
        $this->setLabel(AmosSondaggi::tHtml('amossondaggi', 'Ultimi sondaggi'));
        $this->setDescription(AmosSondaggi::t('amossondaggi', 'Elenca gli ultimi sondaggi'));
    }

    /**
     * 
     * @return string
     */
    public function getHtml() {
        $search = new SondaggiSearch();
        $search->setNotifier(new NotifyWidgetDoNothing());


        $listaSondaggi = $search->ultimiSondaggi($_GET, 3);
        $viewToRender = 'ultimi_sondaggi';


        return $this->render($viewToRender, [
                    'lista' => $listaSondaggi,
                    'widget' => $this,
                    'toRefreshSectionId' => 'widgetGraphicSondaggi'
        ]);
    }

}
