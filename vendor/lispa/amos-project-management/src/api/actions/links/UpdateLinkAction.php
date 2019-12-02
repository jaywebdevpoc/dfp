<?php

namespace lispa\amos\projectmanagement\api\actions\links;

use yii\base\ErrorException;
use yii\rest\UpdateAction;

class UpdateLinkAction extends UpdateAction
{

    public function run($id)
    {
        $model = parent::run($id);
        return $model;
    }

}