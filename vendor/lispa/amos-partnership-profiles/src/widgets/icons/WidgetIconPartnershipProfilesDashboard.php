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
 * Class WidgetIconPartnershipProfilesDashboard
 * @package lispa\amos\partnershipprofiles\widgets\icons
 */
class WidgetIconPartnershipProfilesDashboard extends WidgetIcon
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

        $this->setLabel(Module::tHtml('amospartnershipprofiles', '#widget_icon_partnership_profiles_dashboard_label'));
        $this->setDescription(Module::t('amospartnershipprofiles', '#widget_icon_partnership_profiles_dashboard_description'));

        if (!empty(\Yii::$app->params['dashboardEngine']) && \Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('propostecollaborazione');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('partnership-profiles');
        }

        $this->setUrl(['/partnershipprofiles']);
        $this->setCode('PARTNERSHIP_PROFILES_DASHBOARD');
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
        $widgetAll = new WidgetIconPartnershipProfilesAll();
        $widgetCreatedBy = new WidgetIconPartnershipProfilesCreatedBy();

        return $widgetAll->getBulletCount() + $widgetCreatedBy->getBulletCount();
    }
}
