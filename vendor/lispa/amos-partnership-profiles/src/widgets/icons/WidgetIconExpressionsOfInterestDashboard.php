<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\widgets\icons;

use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\partnershipprofiles\Module;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconExpressionsOfInterestDashboard
 * @package lispa\amos\partnershipprofiles\widgets\icons
 */
class WidgetIconExpressionsOfInterestDashboard extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $paramsClassSpan = [
            'bk-backgroundIcon',
            'color-primary'
        ];

        $this->setLabel(Module::tHtml('amospartnershipprofiles', '#expressions_interest'));
        $this->setDescription(Module::t('amospartnershipprofiles', '#expressions_interest_description'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('propostecollaborazione');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('partnership-profiles');
        }

        $this->setUrl(['/partnershipprofiles/expressions-of-interest/created-by']);
        $this->setCode('EXPRESSIONS_OF_INTEREST');
        $this->setModuleName('partnershipprofiles');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                $paramsClassSpan
            )
        );

        $this->setBulletCount(
            $this->makeBulletCounter(
                Yii::$app->getUser()->getId()
            )
        );
    }

    /**
     * @param null $userId
     * @param null $className
     * @param null $externalQuery
     * @return string
     */
    public function makeBulletCounter($userId = null, $className = null, $externalQuery = null)
    {
        $widgetReceived = new WidgetIconExpressionsOfInterestReceived();
        $widgetCreatedBy = new WidgetIconExpressionsOfInterestCreatedBy();

        return $widgetReceived->getBulletCount() + $widgetCreatedBy->getBulletCount();
    }
}
