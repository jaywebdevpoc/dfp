<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    backend\modules\cfw_organizzazioni\rules
 * @category   CategoryName
 */

namespace lispa\amos\organizzazioni\rules;

use lispa\amos\core\rules\BasicContentRule;


/**
 * Class UpdateRespStructureOrganizationsRule
 * @package backend\modules\cfw_organizzazioni\rules
 */
class UpdateLegalOperationalReferenceRule extends BasicContentRule
{
    public $name = 'UpdateLegalOperationalReferenceRule';

    /**
     * @inheritdoc
     */
    public function ruleLogic($user, $item, $params, $model)
    {
        /** @var Profilo $model */

        if (!($model instanceof Profilo)) {
            return false;
        }
       
        return (
            in_array(
                $user, 
                array($model->rappresentante_legale, $model->referente_operativo)
            )
        );
    }
}
