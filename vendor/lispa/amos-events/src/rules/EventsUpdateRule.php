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

use lispa\amos\community\models\Community;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\record\Record;
use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\Event;

/**
 * Class EventsUpdateRule
 * @package lispa\amos\events\rules
 */
class EventsUpdateRule extends \lispa\amos\core\rules\BasicContentRule
{
    public $name = 'EventsUpdate';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['model'])) {
            /** @var Record $model */
            $model = $params['model'];

            /** @var AmosEvents $eventsModule */
            $eventsModule = AmosEvents::instance();
            if (is_null($eventsModule)) {
                return false;
            }

            if ($model::className() == $eventsModule->model('Event')) {

                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    } elseif (array_key_exists('eid', $get)) {
                        /** @var Event $eventModel */
                        $eventModel = $eventsModule->createModel('Event');
                        $event = $eventModel::findOne(['id' => $get['eid']]);
                        if ($event) {
                            $model = $event;
                        }
                    } else {
                        return false;
                    }
                }

                return $this->ruleLogic($user, $item, $params, $model);

            } elseif ($model::className() == Community::className()) {

                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    } else {
                        return false;
                    }
                }

                return $this->ruleLogicForCommunity($user, $item, $params, $model);

            }
        }

        return false;
    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->community_id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
        if (empty($communityUserMm)) {
            return false;
        }

        return true;
    }

    /**
     * Rule to Read Community
     * @inheritdoc
     */
    public function ruleLogicForCommunity($user, $item, $params, $model)
    {
        $communityUserMm = CommunityUserMm::find()->andWhere(['community_id' => $model->id, 'role' => Event::EVENT_MANAGER])->andWhere(['user_id' => $user])->one();
        if (empty($communityUserMm)) {
            return false;
        }
        return true;
    }
}
