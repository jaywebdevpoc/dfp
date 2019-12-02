<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    e015\common\events
 * @category   CategoryName
 */

namespace lispa\amos\privileges\events;

use yii\base\Event;

/**
 * Class PrivilegesEvent
 * @package lispa\amos\privileges\events
 */
class PrivilegesEvent extends Event
{
    /**
     * @var int $userId
     */
    public $userId;

    /**
     * @var string $privilege
     */
    public $privilege;
}
