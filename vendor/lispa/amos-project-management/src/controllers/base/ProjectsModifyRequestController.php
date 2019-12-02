<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\controllers\base
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\controllers\base;

use lispa\amos\core\controllers\CrudController;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\models\ProjectsAtModifyRequestMm;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\search\ProjectsModifyRequestSearch;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

/**
 * Class ProjectsModifyRequestController
 * ProjectsModifyRequestController implements the CRUD actions for ProjectsModifyRequest model.
 *
 * @property \lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
 *
 * @package lispa\amos\projectmanagement\controllers\base
 */
class ProjectsModifyRequestController extends CrudController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setModelObj(new ProjectsModifyRequest());
        $this->setModelSearch(new ProjectsModifyRequestSearch());

        $this->setAvailableViews([
            'grid' => [
                'name' => 'grid',
                'label' => Module::t('amoscore', '{iconaTabella}' . Html::tag('p', Module::t('amoscore', 'Table')), [
                    'iconaTabella' => AmosIcons::show('view-list-alt')
                ]),
                'url' => '?currentView=grid'
            ],
        ]);

        parent::init();
    }

    /**
     * @param null $layout
     * @param $pid
     * @return string
     * @throws ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($layout = NULL, $pid = null)
    {
        $this->setUpLayout('list');
        if (!Yii::$app->user->can(ProjectsModifyRequestIndexRule::className())) {
            throw new ForbiddenHttpException(Module::t('amosproject_management', '#ACCESS_DENIED_GENERAL'));
        }
        Url::remember();
        \Yii::$app->view->params['createNewBtnParams'] = [
            'urlCreateNew' => ['create', 'pid' => $pid],
        ];
        $this->setDataProvider($this->getModelSearch()->search(Yii::$app->request->getQueryParams()));
        return parent::actionIndex();
    }

    /**
     * Displays a single ProjectsModifyRequest model.
     * @param integer $id
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $this->setUpLayout('main');
        $this->model = $this->findModel($id);

        if ($this->model->load(Yii::$app->request->post()) && $this->model->save()) {
            return $this->redirect(['view', 'id' => $this->model->id]);
        } else {
            return $this->render('view', ['model' => $this->model]);
        }
    }

    /**
     * Creates a new ProjectsModifyRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($pid)
    {
        $this->setUpLayout('form');
        $this->model = new ProjectsModifyRequest();
        $project = Projects::findOne($pid);
        if (empty($project)) {
            throw new InvalidParamException();
        }
        $this->model->projects_id = $project->id;

        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            $saveOk = true;
            if ($this->model->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE) {
                $this->model->status = ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT;
                $saveOk = $this->model->save();
                $this->model->status = ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE;
            }
            if ($this->model->status == ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED) {
                $this->model->status = ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT;
                $saveOk = $this->model->save();
                $this->model->status = ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED;
            }
            if ($saveOk && $this->model->save()) {
                $this->saveItems($this->model);
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Item created'));
                return $this->redirectOnCreate();
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Item not created, check data'));
            }
        }

        return $this->render('create', [
            'model' => $this->model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    protected function redirectOnCreate()
    {
        $redirectToUpdatePage = false;

        if (Yii::$app->getUser()->can('PROJECTSMODIFYREQUEST_UPDATE', ['model' => $this->model])) {
            $redirectToUpdatePage = true;
        }

        if (Yii::$app->getUser()->can(ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED, ['model' => $this->model])) {
            $redirectToUpdatePage = true;
        }

        if ($redirectToUpdatePage) {
            $url = ['update', 'id' => $this->model->id];
        } else {
            $url = Url::previous() . '#tab-modify-request';
        }

        return $this->redirect($url);
    }

    /**
     * @param ProjectsModifyRequest $model
     */
    private function saveItems($model)
    {
        ProjectsAtModifyRequestMm::deleteAll(['projects_modify_request_id' => $model->id]);
        // SAVE of items request
        if (isset(Yii::$app->request->post()['selection'])) {
            $itemsArray = Projects::getItemsWorkPlanArray($model->projects_id);
            foreach (Yii::$app->request->post('selection') as $rawId) {
                if (isset($itemsArray[$rawId])) {
                    switch ($itemsArray[$rawId]['class']) {
                        case ProjectsTasks::className():
                            $mmItem = new ProjectsAtModifyRequestMm();
                            $mmItem->projects_modify_request_id = $model->id;
                            $mmItem->projects_tasks_id = $itemsArray[$rawId]['id'];
                            $mmItem->save(false);
                            break;
                        case ProjectsActivities::className():
                            $mmItem = new ProjectsAtModifyRequestMm();
                            $mmItem->projects_modify_request_id = $model->id;
                            $mmItem->projects_activities_id = $itemsArray[$rawId]['id'];
                            $mmItem->save(false);
                            break;
                    }
                }
            }
        }
    }

    /**
     * Updates an existing ProjectsModifyRequest model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $this->setUpLayout('form');
        $this->model = $this->findModel($id);

        if (empty($this->model)) {
            throw new InvalidParamException();
        }

        if ($this->model->load(Yii::$app->request->post()) && $this->model->validate()) {
            if ($this->model->save()) {
                $this->saveItems($this->model);
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Item updated'));
                if ($this->model->status != ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT) {
                    return $this->redirect(Url::previous() . '#tab-modify-request');
                }
                return $this->render('update', [
                    'model' => $this->model,
                ]);
            } else {
                Yii::$app->getSession()->addFlash('danger', Module::t('amoscore', 'Item not updated, check data'));
                return $this->render('update', [
                    'model' => $this->model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $this->model,
            ]);
        }
    }

    /**
     * Deletes an existing ProjectsModifyRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \Exception
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->setUpLayout('list');
        $this->model = $this->findModel($id);
        if ($this->model) {
            $pid = $this->model->projects_id;
            $this->model->delete();
            if (!empty($this->model->deleted_at)) {
                Yii::$app->getSession()->addFlash('success', Module::t('amoscore', 'Item deleted'));
            }
            $action = 'index-mine';
            if (ProjectManagementUtility::loggedUsedIsCommunityManager($this->model->projects->community_id)) {
                $action = 'index';
            }
            return $this->redirect([$action, 'pid' => $pid]);
        } else {
            throw new InvalidParamException();
        }
    }
}
