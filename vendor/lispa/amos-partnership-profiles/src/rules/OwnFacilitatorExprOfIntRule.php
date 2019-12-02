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

use lispa\amos\admin\rules\DefaultFacilitatorOwnContentRule;
use lispa\amos\partnershipprofiles\models\ExpressionsOfInterest;
use lispa\amos\partnershipprofiles\models\PartnershipProfiles;

/**
 * Class OwnFacilitatorExprOfIntRule
 * @package lispa\amos\partnershipprofiles\rules
 */
abstract class OwnFacilitatorExprOfIntRule extends DefaultFacilitatorOwnContentRule
{
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        $ok = false;
        if (parent::execute($user, $item, $params)) {
            if (isset($params['model'])) {
                /** @var ExpressionsOfInterest $model */
                $model = $params['model'];
                if (!$model->id) {
                    $post = \Yii::$app->getRequest()->post();
                    $get = \Yii::$app->getRequest()->get();
                    if (isset($get['id'])) {
                        $model = $this->instanceModel($model, $get['id']);
                    } elseif (isset($post['id'])) {
                        $model = $this->instanceModel($model, $post['id']);
                    }
                }
                $allowedPartnershipProfileStates = [
                    PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_VALIDATED,
                    PartnershipProfiles::PARTNERSHIP_PROFILES_WORKFLOW_STATUS_FEEDBACKRECEIVED
                ];
                $ok = (
                    ($model->status == ExpressionsOfInterest::EXPRESSIONS_OF_INTEREST_WORKFLOW_STATUS_DRAFT) &&
                    in_array($model->partnershipProfile->status, $allowedPartnershipProfileStates)
                );
            }
        }
        return $ok;
    }
}
