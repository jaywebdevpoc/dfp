<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\widgets\graphics
 * @category   CategoryName
 */

namespace lispa\amos\community\widgets\graphics;

use lispa\amos\community\AmosCommunity;
use lispa\amos\community\models\search\CommunitySearch;
use lispa\amos\core\widget\WidgetGraphic;
use lispa\amos\notificationmanager\base\NotifyWidgetDoNothing;

/**
 * Class WidgetGraphicsMyCommunities
 * @package lispa\amos\community\widgets\graphics
 */
class WidgetGraphicsCommunitiesRecommended extends WidgetGraphic
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->setCode('COMMUNITIES_RECOMMENDED_GRAPHIC');
        $this->setLabel(AmosCommunity::t('amoscommunity', 'Communities Recommended'));
        $this->setDescription(AmosCommunity::t('amoscommunity', 'View the list of communities recommended'));
    }
    
    /**
     * @return string
     */
    public function getHtml()
    {
        $search = new CommunitySearch();
        $search->setNotifier(new NotifyWidgetDoNothing());
        
        $viewPath = '@vendor/lispa/amos-community/src/widgets/graphics/views/';
        $viewToRender = $viewPath . 'communities_recommended';

        if(isset(\Yii::$app->params['WidgetGraphicsCommunitiesRecommended_limit']))
        {
            $numberToView = \Yii::$app->params['WidgetGraphicsCommunitiesRecommended_limit'];
        }else{
            $numberToView = 3;
        }
        if (is_null(\Yii::$app->getModule('layout'))) {
            $viewToRender .= '_old';
        }
        
        /** show subcommunities if you are inside a community and if you have anabled show subcommunities */
        $moduleCommunity = \Yii::$app->getModule('community');
        $showSubscommunities = $moduleCommunity->showSubcommunities;
        $linkToSubcommunities = false;
        /** @var \lispa\amos\cwh\AmosCwh $moduleCwh */
        if ($showSubscommunities) {
            $moduleCwh = \Yii::$app->getModule('cwh');
            if (!is_null($moduleCwh)) {
                $scope = $moduleCwh->getCwhScope();
                if (!empty($scope) && isset($scope['community'])) {
                    $search->subcommunityMode = true;
                    $linkToSubcommunities = true;
                }
            }
        }
        
        $communitiesList = $search->searchCommunitiesRecommended($_GET, $numberToView);
       
        return $this->render(
            $viewToRender,
            [ 
                'communitiesList' => $communitiesList,
                'widget' => $this,
                'toRefreshSectionId' => 'widgetGraphicsCommunitiesRecommended',
                'linkToSubcommunities' => $linkToSubcommunities
            ]
        );
    }
}
