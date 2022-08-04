<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq\widgets\icons
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace open20\amos\faq\widgets\icons;

use open20\amos\core\widget\WidgetIcon;
use open20\amos\faq\AmosFaq;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconFaq
 * @package open20\amos\faq\widgets\icons
 */
class WidgetIconFaqStati extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosFaq::tHtml('amosfaq', 'Gestione Stati FAQ'));
        $this->setDescription(AmosFaq::t('amosfaq', 'Gestione degli stati delle FAQ'));
        
        $this->setIcon('question-circle');
        
        $this->setUrl(['/faq/faq-stato/index']);
        $this->setCode('FAQ_MODULE_003');
        $this->setModuleName('faq');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-darkPrimary'
        ]));
    }
}
