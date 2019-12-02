<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\community\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;
use lispa\amos\core\widget\WidgetAbstract;
use lispa\amos\core\icons\AmosIcons;

use lispa\amos\community\AmosCommunity;
use lispa\amos\community\models\Community;
use lispa\amos\community\models\search\CommunitySearch;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconMyCommunitiesWithTags
 * @package lispa\amos\community\widgets\icons
 */
class WidgetIconMyCommunitiesWithTags extends WidgetIcon
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

        $this->setLabel(AmosCommunity::tHtml('amoscommunity', '#communities_of_interest'));
        $this->setDescription(AmosCommunity::t('amoscommunity', '#communities_of_interest_description'));

        if (!empty(Yii::$app->params['dashboardEngine']) && Yii::$app->params['dashboardEngine'] == WidgetAbstract::ENGINE_ROWS) {
            $this->setIconFramework(AmosIcons::IC);
            $this->setIcon('community');
            $paramsClassSpan = [];
        } else {
            $this->setIcon('group');
        }

        $url = ['/community/community/own-interest-communities'];

        $this->setUrl($url);
        $this->setCode('COMMUNITY');
        $this->setModuleName('community');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                $paramsClassSpan
            )
        );

        $search = new CommunitySearch();
        $this->setBulletCount(
            $this->makeBulletCounter(
                Yii::$app->getUser()->id,
                Community::className(),
                $search->buildQuery([], 'own-interest-with-tags')
            )
        );
    }

    /**
     * 
     * @return type
     */
    public static function widgetLabel()
    {
        return AmosCommunity::t('amoscommunity', '#communities_of_interest');
    }

}
