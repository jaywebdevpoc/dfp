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
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;
use lispa\amos\partnershipprofiles\models\search\PartnershipProfilesSearch;
use lispa\amos\partnershipprofiles\Module;
use Yii;

/**
 * Class WidgetIconPartnershipProfilesAll
 * @package lispa\amos\partnershipprofiles\widgets\icons
 */
class WidgetIconPartnershipProfilesAll extends WidgetIcon
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

        $this->setLabel(Module::tHtml('amospartnershipprofiles', 'All'));
        $this->setDescription(Module::t('amospartnershipprofiles', 'All Partnership Profiles entities'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('propostecollaborazione');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('partnership-profiles');
        }

        $this->setUrl(['/partnershipprofiles/partnership-profiles/index']);
        $this->setCode('PARTNERSHIP_PROFILES_ALL');
        $this->setModuleName('partnershipprofiles');
        $this->setNamespace(__CLASS__);

        $search = new PartnershipProfilesSearch();
        $this->setBulletCount(
            $this->makeBulletCounter(
                Yii::$app->getUser()->getId(),
                PartnershipProfiles::class,
                $search->searchAllQuery([])
            )
        );
    }
}
