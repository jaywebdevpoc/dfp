<?php
/**
 * Error handler version for web based modules
 */

namespace lispa\amos\audit\components\web;

use lispa\amos\audit\components\base\ErrorHandlerTrait;

/**
 * ErrorHandler
 * @package lispa\amos\audit\components\web
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    use ErrorHandlerTrait;
}