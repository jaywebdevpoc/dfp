<?php
/**
 * Console compatible error handler
 */

namespace lispa\amos\audit\components\console;

use lispa\amos\audit\components\base\ErrorHandlerTrait;

/**
 * ErrorHandler
 * @package lispa\amos\audit\components\console
 */
class ErrorHandler extends \yii\console\ErrorHandler
{
    use ErrorHandlerTrait;
}