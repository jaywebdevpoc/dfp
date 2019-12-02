<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\rules
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\rules;

use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use yii\rbac\Rule;

/**
 * Class ProjectsMeasureCreateRule
 * @package lispa\amos\projectmanagement\rules
 */
class ProjectsMeasureCreateRule extends Rule
{
    public $name = 'projectsMeasureCreate';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return ProjectManagementUtility::loggedUserIsCommunityManager();
    }
}
