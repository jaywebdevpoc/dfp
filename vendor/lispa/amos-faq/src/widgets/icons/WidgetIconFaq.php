<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq\widgets\icons
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\faq\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\faq\AmosFaq;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconFaq
 * @package lispa\amos\faq\widgets\icons
 */
class WidgetIconFaq extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosFaq::tHtml('amosfaq', 'Gestione FAQ'));
        $this->setDescription(AmosFaq::t('amosfaq', 'Gestione delle FAQ'));
        
        $this->setIcon('question-circle');
        
        $this->setUrl(['/faq/faq/index']);
        $this->setCode('FAQ_MODULE_001');
        $this->setModuleName('faq');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-darkPrimary'
        ]));
    }
}
