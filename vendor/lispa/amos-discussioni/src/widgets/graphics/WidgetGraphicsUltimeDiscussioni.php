<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\discussioni
 * @category   CategoryName
 */

namespace lispa\amos\discussioni\widgets\graphics;

use lispa\amos\core\widget\WidgetGraphic;
use lispa\amos\discussioni\AmosDiscussioni;
use lispa\amos\discussioni\models\search\DiscussioniTopicSearch;
use lispa\amos\notificationmanager\base\NotifyWidgetDoNothing;
use lispa\amos\core\widget\WidgetAbstract;

/**
 * Class WidgetGraphicsUltimeDiscussioni
 * informational widget that lists the latest discussions
 *
 * @package lispa\amos\discussioni\widgets\graphics
 */
class WidgetGraphicsUltimeDiscussioni extends WidgetGraphic {

  /**
   * @inheritdoc
   */
  public function init() {
    parent::init();
    
    $this->setCode('ULTIME_DISCUSSIONI_GRAPHIC');
    $this->setLabel(AmosDiscussioni::tHtml('amosdiscussioni', 'Ultime discussioni'));
    $this->setDescription(AmosDiscussioni::t('amosdiscussioni', 'Elenca le ultime discussioni create'));
  }

  
  /**
   * Rendering of the view ultime_discussioni
   *
   * @return string
   */
  public function getHtml() {
    $search = new DiscussioniTopicSearch();
    $search->setNotifier(new NotifyWidgetDoNothing());
    $listaTopic = $search->ultimeDiscussioni($_GET, AmosDiscussioni::MAX_LAST_DISCUSSION_ON_DASHBOARD);
    
    $viewPath = '@vendor/lispa/amos-discussioni/src/widgets/graphics/views/';
    $viewToRender = $viewPath . 'ultime_discussioni';
    if (is_null(\Yii::$app->getModule('layout'))) {
      $viewToRender .= '_old';
    }

    return $this->render(
      $viewToRender,
      [
        'listaTopic' => $listaTopic,
        'widget' => $this,
        'toRefreshSectionId' => 'widgetGraphicLatestThreads'
      ]
    );
  }

}