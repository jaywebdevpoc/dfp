<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\widgets\icons
 * @category   CategoryName
 */

namespace lispa\amos\events\widgets\icons;

use lispa\amos\core\widget\WidgetIcon;

use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\search\EventSearch;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEventOwnInterest
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventOwnInterest extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLabel(AmosEvents::t('amosevents', 'Own Interest Events'));
        $this->setDescription(AmosEvents::t('amosevents', 'Own Interest Events'));
        $this->setLabel(AmosEvents::t('amosevents', '#widget_icon_event_own_interest_label'));
        $this->setDescription(AmosEvents::t('amosevents', '#widget_icon_event_own_interest_description'));
        $this->setIcon('calendar');
        $this->setUrl(['/events/event/own-interest']);
        $this->setCode('EVENT_OWN_INTEREST');
        $this->setModuleName('events');
        $this->setNamespace(__CLASS__);

        $this->setClassSpan(
            ArrayHelper::merge(
                $this->getClassSpan(),
                [
                    'bk-backgroundIcon',
                    'color-lightPrimary'
                ]
            )
        );

        if ($this->disableBulletCounters == false) {
            /** @var AmosEvents $eventsModule */
            $eventsModule = AmosEvents::instance();
            /** @var EventSearch $search */
            $search = $eventsModule->createModel('EventSearch');
            $this->setBulletCount(
                $this->makeBulletCounter(
                    Yii::$app->getUser()->getId(),
                    $eventsModule->model('Event'),
                    $search->buildQuery([], 'own-interest')
                )
            );
        }
    }
}
