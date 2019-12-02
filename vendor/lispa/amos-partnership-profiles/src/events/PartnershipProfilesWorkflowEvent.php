<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\events
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\events;

use lispa\amos\partnershipprofiles\models\ExpressionsOfInterest;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;
use yii\base\Event;
use yii\base\BaseObject;

/**
 * Class PartnershipProfilesWorkflowEvent
 * @package lispa\amos\partnershipprofiles\events
 */
class PartnershipProfilesWorkflowEvent extends BaseObject
{
    /**
     * @param \yii\base\Event $yiiEvent
     * @return bool
     */
    public function updatePartnershipProfileStatus(Event $yiiEvent)
    {
        /** @var ExpressionsOfInterest $expressionOfInterest */
        $expressionOfInterest = $yiiEvent->data;
        $partnershipProfile = $expressionOfInterest->partnershipProfile;
        $ok = true;
        if ($partnershipProfile->status == PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_VALIDATED) {
            $partnershipProfile->sendToStatus(PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_FEEDBACKRECEIVED);
            $ok = $partnershipProfile->save(false);
        }
        return $ok;
    }
}
