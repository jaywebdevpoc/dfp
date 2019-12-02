<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\core\interfaces
 * @category   CategoryName
 */

namespace lispa\amos\core\interfaces;

/**
 * Interface InvitationExternalInterface
 * @package lispa\amos\core\interfaces
 */
interface InvitationExternalInterface
{
    /**
     * This method make the association from the specified context model and the specified user.
     * @param int $userId
     * @param int $modelId
     * @return bool
     */
    public function addUserContextAssociation($userId, $modelId);
}
