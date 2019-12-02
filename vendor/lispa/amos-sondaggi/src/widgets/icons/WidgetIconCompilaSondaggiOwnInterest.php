<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\sondaggi\AmosSondaggi;
use yii\helpers\ArrayHelper;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\widget\WidgetAbstract;

/**
 * Class WidgetIconCompilaSondaggiOwnInterest
 * @package lispa\amos\sondaggi\widgets\icons
 */
class WidgetIconCompilaSondaggiOwnInterest extends WidgetIcon
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLabel(AmosSondaggi::tHtml('amossondaggi', 'Sondaggi di mio interesse'));
        $this->setDescription(AmosSondaggi::t('amossondaggi', 'Permette di compilare e completare i sondaggi di tuo interesse'));

        if (!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('sondaggi');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('quote-right');
        }

        $this->setUrl(['/sondaggi/pubblicazione/own-interest']);
        $this->setCode('COMP_SONDAGGI_OWN_INTEREST');
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

}
