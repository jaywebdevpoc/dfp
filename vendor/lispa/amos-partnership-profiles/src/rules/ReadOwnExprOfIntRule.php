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
use lispa\amos\partnershipprofiles\models\ExpressionsOfInterest;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;

/**
 * Class ReadOwnExprOfIntRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class ReadOwnExprOfIntRule extends BasicContentRule
{
    public $name = 'readOwnExprOfInt';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        // Default to true for lists
        $canRead = true;

        if (($model instanceof ExpressionsOfInterest) && $model->id) {
            /** @var ExpressionsOfInterest $model */
            $canRead = false;
            $allowedStates = [
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_VALIDATED,
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_FEEDBACKRECEIVED,
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_ARCHIVED,
                PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_CLOSED
            ];

            if (in_array($model->partnershipProfile->status, $allowedStates)) {
                if ($user == $model->created_by) {
                    // Check if user is the expression of interest creator
                    $canRead = true;
                } elseif (!is_null($model->createdUserProfile->facilitatore) && ($user == $model->createdUserProfile->facilitatore->user_id)) {
                    // Check if user is the facilitator of the expression of interest creator
                    $canRead = true;
                } elseif ($user == $model->partnershipProfile->created_by) {
                    // Check if user is the creator of the expression of interest related partnership profile
                    $canRead = true;
                } elseif (!is_null($model->partnershipProfile->partnershipProfileFacilitator) && ($user == $model->partnershipProfile->partnershipProfileFacilitator->user_id)) {
                    // Check if user is the facilitator of the expression of interest related partnership profile
                    $canRead = true;
                }
            }
        }

        return $canRead;
    }
}
