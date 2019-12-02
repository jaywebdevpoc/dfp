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

use lispa\amos\community\models\Community;
use lispa\amos\projectmanagement\models\Projects;

/**
 * Class ProjectManagerByCommunityRoleRule
 * @package lispa\amos\projectmanagement\rules
 */
class ProjectManagerByCommunityRoleRule extends ByCommunityRoleRule
{
    public $name = 'projectManagerByCommunityRole';

    /**
     * @inheritdoc
     */
    protected function checkCommunityRole($userCommunityRole)
    {
        return ($userCommunityRole === Community::ROLE_COMMUNITY_MANAGER);
    }
}
