<?php

namespace lispa\amos\partnershipprofiles\widgets\graphics;

use lispa\amos\core\widget\WidgetGraphic;
use lispa\amos\partnershipprofiles\models\search\PartnershipProfilesSearch;
use lispa\amos\partnershipprofiles\Module;

use Yii;
use yii\helpers\ArrayHelper;

class WidgetGraphicsLatestPartnershipProfiles extends WidgetGraphic {

  /**
   * 
   */
  public function init() {
    parent::init();

    $this->setLabel(\Yii::t('amospartenershipprofiles', 'Latest partnership profiles'));
    $this->setDescription(Yii::t('amospartenershipprofile', 'Latest partnership profiles'));
  }

  /**
   * rendering of the view ultime_discussioni
   *
   * @return string
   */
  public function getHtml() {
    $modelSearch = new PartnershipProfilesSearch();
    $listaPartenership = $modelSearch->latestPartenershipProfilesSearch($_GET, Module::MAX_LAST_PARTNERSHIP_ON_DASHBOARD);

    $viewToRender = 'latest_partenership_profiles';

    if (is_null(\Yii::$app->getModule('layout'))) {
      $viewToRender = 'latest_partenership_profiles_old';
    }

    return $this->render($viewToRender, [
        'listaPartnership' => $listaPartenership,
        'widget' => $this,
        'toRefreshSectionId' => 'widgetGraphicLatestThreads'
    ]);
  }

}
