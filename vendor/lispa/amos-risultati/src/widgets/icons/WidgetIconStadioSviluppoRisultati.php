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
 * Class WidgetIconStadioSviluppoRisultati
 * @package lispa\amos\risultati\widgets\icons
 */
class WidgetIconStadioSviluppoRisultati extends WidgetIcon
{
    public function init()
    {
        parent::init();
        $this->setLabel(AmosRisultati::t('amosrisultati', 'Stadio sviluppo risultati'));
        $this->setDescription(AmosRisultati::t('amosrisultati', 'Consente all\'utente di modificare l\'entità Risultati'));
        $this->setIcon('linentita');
        $this->setUrl(['/risultati/stadio-sviluppo-risultati/index']);
        $this->setCode('STADIO_SVILUPPO_RISULTATI');
        $this->setModuleName('risultati');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-secondary'
        ]));
    }
}
