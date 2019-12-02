<?php

namespace lispa\amos\events\controllers\api;

/**
* This is the class for REST controller "EventAccreditationListController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class EventAccreditationListController extends \yii\rest\ActiveController
{
public $modelClass = 'lispa\amos\events\models\EventAccreditationList';
}
