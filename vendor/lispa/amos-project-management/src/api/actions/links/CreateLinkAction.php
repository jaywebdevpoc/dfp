<?php

namespace lispa\amos\projectmanagement\api\actions\links;

use lispa\amos\projectmanagement\models\ProjectsTasksTasksMm;
use lispa\amos\projectmanagement\Module;
use yii\base\ErrorException;
use yii\db\ActiveRecord;
use yii\rest\CreateAction;

class CreateLinkAction extends CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        /**@var ActiveRecord $modelClass */
        /**@var ActiveRecord $model */
        $modelClass = $this->modelClass;

        $params = [
            'projects_tasks_id' => str_replace('t-', '', $_POST['source']),
            'tasks_id' => str_replace('t-', '', $_POST['target']),
            'type' => ProjectsTasksTasksMm::typeNumberToIdentiffier($_POST['type'])
        ];
        //throw new ErrorException(Module::t('amosgantt', 'Si è verificato un errore durante il salvataggio'));

        $model = $modelClass::findOne($params);

        if (!$model) {
            $model = new $modelClass;
            $model->load($params, '');
            if (!$model->save()) {
                throw new ErrorException(Module::t('amosgantt', 'Si è verificato un errore durante il salvataggio'));
            }
        }
        return $model;
    }
}