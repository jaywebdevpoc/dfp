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

/**
 *
 * @deprecated
 * Class WidgetGraphicsDiscussioniInEvidenza
 * informational widget that lists threads in evidence
 * @package lispa\amos\discussioni\widgets\graphics
 */
class WidgetGraphicsDiscussioniInEvidenza extends WidgetGraphic {

  /**
   * @inheritdoc
   */
  public function init() {
    parent::init();
    
    $this->setCode('ULTIME_DISCUSSIONI_GRAPHIC');
    $this->setLabel(AmosDiscussioni::tHtml('amosdiscussioni', 'Discussioni in evidenza'));
    $this->setDescription(AmosDiscussioni::t('amosdiscussioni', 'Elenca le ultime discussioni in evidenza'));
  }

  /**
   * Rendering of the view discussioni_in_evidenza
   *
   * @return string
   */
  public function getHtml() {
    $listaTopic = (new DiscussioniTopicSearch())->discussioniInEvidenza($_GET, AmosDiscussioni::MAX_LAST_DISCUSSION_ON_DASHBOARD);
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
        'toRefreshSectionId' => 'widgetGraphicStickyThreads'
      ]
    );
  }

}