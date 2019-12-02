<?php

namespace lispa\amos\projectmanagement\controllers;


use lispa\amos\projectmanagement\api\actions\links\CreateLinkAction;
use lispa\amos\projectmanagement\api\actions\links\RemoveLinkAction;
use lispa\amos\projectmanagement\api\actions\links\UpdateLinkAction;
use lispa\amos\projectmanagement\models\base\ProjectsTasksTasksMm;
use yii\rest\ActiveController;

/**
 * Class RestLinkController
 *
 * @package lispa\amos\projectmanagement\controllers
 *
 */
class RestLinkController extends ActiveController
{

    public $modelClass = 'lispa\amos\projectmanagement\models\base\ProjectsTasksTasksMm';

    public function actions()
    {
        return [
            'create' => [
                'class' => CreateLinkAction::className(),
                'modelClass' => ProjectsTasksTasksMm::className(),
            ],
            'update' => [
                'class' => UpdateLinkAction::className(),
                'modelClass' => ProjectsTasksTasksMm::className(),
            ],
            'remove' => [
                'class' => RemoveLinkAction::className(),
                'modelClass' => ProjectsTasksTasksMm::className(),
            ],
        ];
    }
}
