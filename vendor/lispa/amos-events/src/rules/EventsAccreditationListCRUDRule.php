<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\rules
 * @category   CategoryName
 */

namespace lispa\amos\events\rules;

use lispa\amos\admin\models\UserProfile;
use lispa\amos\community\models\Community;
use lispa\amos\community\models\CommunityType;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\record\Record;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\Event;
use lispa\amos\events\models\EventAccreditationList;
use lispa\amos\partnershipprofiles\models\ExpressionsOfInterest;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;

/**
 * Class EventsAccreditationListCRUDRule
 * @package lispa\amos\events\rules
 */
class EventsAccreditationListCRUDRule extends \lispa\amos\core\rules\BasicContentRule
{
    public $name = 'EventsAccreditationListCRUDRule';

    /**
     * @var AmosEvents $eventsModule
     */
    public $eventsModule = null;


    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $this->eventsModule = \Yii::$app->getModule('events');

        if (isset($params['model'])) {
            /** @var Record $model */
            $model = $params['model'];
            if (!$model->id) {
                $post = \Yii::$app->getRequest()->post();
                $get = \Yii::$app->getRequest()->get();
                if (isset($get['id'])) {
                    $model = $this->instanceModel($model, $get['id']);
                } elseif (isset($post['id'])) {
                    $model = $this->instanceModel($model, $post['id']);
                } elseif(array_key_exists('eid', $get)) {
                    /** @var Event $eventModel */
                    $eventModel = $this->eventsModule->createModel('Event');
                    $model = $eventModel::findOne(['id' => $get['eid']]);
                }
            }
            return $this->ruleLogic($user, $item, $params, $model);
        }

        return false;

    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        if($model instanceof Event) {
            $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->community_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
            if (!empty($communityUserMm)) {
                return true;
            }
        } elseif ($model instanceof EventAccreditationList) {
            $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->event_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
            if (!empty($communityUserMm)) {
                return true;
            }
        }

        return false;
    }
}
