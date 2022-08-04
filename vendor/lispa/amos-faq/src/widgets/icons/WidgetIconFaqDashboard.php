<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

namespace lispa\amos\faq\widgets\icons;

use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\faq\AmosFaq;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconFaq
 *
 * @package lispa\amos\faq\widgets\icons
 */
class WidgetIconFaqDashboard extends WidgetIcon
{
    /**
     * Init of the class, set of general configurations
     */
    public function init()
    {
        parent::init();
        $this->setLabel(AmosFaq::tHtml('amosfaq', 'FAQ'));
        $this->setDescription(AmosFaq::t('amosfaq', 'FAQ dashboard'));

        $this->setIcon('question-circle');
        //$this->setIconFramework();
        
        $this->setUrl(Yii::$app->urlManager->createUrl(['faq']));
        $this->setCode('FAQ_MODULE_000');
        $this->setModuleName('faq');
        $this->setNamespace(__CLASS__);
        $this->setClassSpan(ArrayHelper::merge($this->getClassSpan(), [
            'bk-backgroundIcon',
            'color-darkPrimary'
        ]));
    }


    /**
     * all widgets added to the container object retrieved from the module controller
     * @return array
     */
    public function getOptions()
    {
        $options = parent::getOptions();
        return ArrayHelper::merge($options, ["children" => $this->getWidgetsIcon()]);
    }

    /**
     * @todo TEMPORARY
     */
    public function getWidgetsIcon()
    {
        $widgets = [];

        $WidgetIconFaq = new WidgetIconFaq();

        if ($WidgetIconFaq->isVisible()) {
            $widgets[] = $WidgetIconFaq->getOptions();
        }


        return $widgets;
    }

}