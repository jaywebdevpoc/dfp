<?php
/**
 */

namespace brussens\maintenance;

use yii\base\BaseObject;

/**'
 * Class Checker
 * @package brussens\maintenance
 */
abstract class Filter extends BaseObject
{
    /**
     * @return bool
     */
    abstract public function isAllowed();
}