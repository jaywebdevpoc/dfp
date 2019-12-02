<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\controllers\api;

/**
 * This is the class for REST controller "ProjectsMeasureController".
 */

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class ProjectsMeasureController extends \yii\rest\ActiveController
{
    public $modelClass = 'lispa\amos\projectmanagement\models\ProjectsMeasure';
}
