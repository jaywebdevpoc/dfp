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

/**
 * Class ChangePartPropExprsOfIntStatusRule
 * @package lispa\amos\partnershipprofiles\rules
 */
class ChangePartPropExprsOfIntStatusRule extends BasicContentRule
{
    public $name = 'changePartPropExprsOfIntStatus';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        /** @var ExpressionsOfInterest $model */
        return ($model->partnershipProfile->created_by == $user);
    }
}
