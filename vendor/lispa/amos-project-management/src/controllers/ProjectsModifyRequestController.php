<?php

namespace lispa\amos\projectmanagement\controllers;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * This is the class for controller "ProjectsModifyRequestController".
 */
class ProjectsModifyRequestController extends base\ProjectsModifyRequestController
{

    /**
     * Lists all ProjectsModifyRequest models.
     * @param integer $pid
     * @param null $layout
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionIndexMine($layout = NULL, $pid)
    {
        if (!Yii::$app->user->can(ProjectsModifyRequestIndexRule::className())) {
            throw new ForbiddenHttpException(Module::t('amosproject_management', '#ACCESS_DENIED_GENERAL'));
        }
        Url::remember();
        // find project owner
        $project = Projects::findOne($pid);

        if (empty($project)){
            throw new InvalidParamException();
        }

        $this->setDataProvider($this->getModelSearch()->searchMine($project->id, Yii::$app->request->getQueryParams()));
        $this->setUpLayout('list');
        if ($layout) {
            $this->setUpLayout($layout);
        }

        \Yii::$app->view->params['createNewBtnParams'] = [
            'urlCreateNew' => ['create', 'pid' => $pid],
        ];

        return $this->render('index_mine', [
            'dataProvider' => $this->getDataProvider(),
            'model' => $this->getModelSearch(),
            'currentView' => $this->getCurrentView(),
            'availableViews' => $this->getAvailableViews(),
            'url' => ($this->url) ? $this->url : NULL,
            'parametro' => ($this->parametro) ? $this->parametro : NULL,
            'project' => $project
        ]);
    }

}
