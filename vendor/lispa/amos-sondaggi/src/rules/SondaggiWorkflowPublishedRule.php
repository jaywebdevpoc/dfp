<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi
 * @category   CategoryName
 */

namespace lispa\amos\sondaggi\rules;

use lispa\amos\core\rules\DefaultOwnContentRule;


class SondaggiWorkflowPublishedRule extends DefaultOwnContentRule
{
    public $name = 'sondaggiWorkflowPublished';

    public function execute($user, $item, $params)
    {
        if(\Yii::$app->controller->action->id == 'pubblica'){
            return true;
        }
        return false;
    }
}
