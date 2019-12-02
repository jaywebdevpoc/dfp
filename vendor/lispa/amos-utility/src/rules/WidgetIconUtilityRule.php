<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\utility\rules
 * @category   CategoryName
 */

namespace lispa\amos\utility\rules;

use yii\rbac\Rule;

/**
 * Class WidgetIconUtilityRule
 * @package lispa\amos\utility\rules
 */
class WidgetIconUtilityRule extends Rule
{
    public $name = 'widgetIconUtility';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return true;
    }
}
