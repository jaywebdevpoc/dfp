<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\rules
 * @category   CategoryName
 */

namespace lispa\amos\partnershipprofiles\rules;

use lispa\amos\core\rules\BasicContentRule;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;

/**
 * Class PartnershipProfilesCloseStatusRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class PartnershipProfilesCloseStatusRule extends BasicContentRule
{
    public $name = 'partnershipProfilesCloseStatus';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        $canClose = false;

        if ($model instanceof PartnershipProfiles) {
            /** @var PartnershipProfiles $model */
            $allowedUserIds = [
                $model->created_by,
            ];
            $facilitator = $model->partnershipProfileFacilitator;
            if (!is_null($facilitator)) {
                $allowedUserIds[] = $facilitator->user_id;
            }
            $notAllowedStates = [
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_ARCHIVED,
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_FEEDBACKRECEIVED
            ];
            $canClose = (
                in_array($user, $allowedUserIds) &&
                !in_array($model->status, $notAllowedStates)
            );
        }

        return $canClose;
    }
}
