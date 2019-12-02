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
use yii\helpers\ArrayHelper;

/**
 * Class WidgetIconEventsCreatedBy
 * @package lispa\amos\events\widgets\icons
 */
class WidgetIconEventsCreatedBy extends WidgetIcon
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->setLabel(AmosEvents::t('amosevents', 'Events created by me'));
        $this->setDescription(AmosEvents::t('amosevents', 'Events created by me'));
        $this->setIcon('calendar');
        $this->setUrl(['/events/event/created-by']);
        $this->setCode('EVENT_CREATED_BY');
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

//        /** @var AmosEvents $eventsModule */
//        $eventsModule = AmosEvents::instance();
//        /** @var EventSearch $search */
//        $search = $eventsModule->createModel('EventSearch');
//        $dataProvider = $search->searchCreatedBy([]);
//        /** @var AmosEvents $eventsModule */
//        $eventsModule = AmosEvents::instance();
//
//        $this->setBulletCount(
//            $this->makeBulletCounter(
//                Yii::$app->getUser()->getId(),
//                $eventsModule->model('Event'),
//                $dataProvider->query
//            )
//        );
    }
}
