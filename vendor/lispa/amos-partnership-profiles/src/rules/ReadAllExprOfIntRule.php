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
 * Class ReadAllExprOfIntRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class ReadAllExprOfIntRule extends BasicContentRule
{
    public $name = 'ReadAllExprOfInt';

    /**
     * Rule to see the link "see all" Expression of interest
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        /** @var PartnershipProfiles $model */

        if (!is_null($model->partnershipProfileFacilitator) && ($user == $model->partnershipProfileFacilitator->user_id)) {
            // Can see "see all" the facilitator of the PartnershipProfile
            return true;
        } else if ($model->created_by == $user) {
            // Can see "see all" the creator of the PartnershipProfile
            return true;
        } else {
            // Can see "see all" if you are creator of a EOI or if you are FACILITATOR of the creator of EOI
            $exprOfIntList = $model->notDraftExpressionsOfInterest;
            foreach ($exprOfIntList as $exprOfInterest) {
                /** @var ExpressionsOfInterest $exprOfInterest */
                if ($exprOfInterest->created_by == $user) {
                    return true;
                }
                $facilitator = $exprOfInterest->createdUserProfile->facilitatore;
                if (!is_null($facilitator) && ($facilitator->user_id == $user)) {
                    return true;
                }
            }
        }
        return false;
    }
}
