<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
 * @var lispa\amos\projectmanagement\models\Projects $model
 * @var \yii\data\ActiveDataProvider $modifyRequestDataProvider
 * @var \yii\web\View $currentView
 * @var boolean $onlyView
 */

if (!isset($onlyView)) {
    $onlyView = false;
}

$columns = [
    [
        'label' => Module::t('amosproject_management', 'Request sender'),
        'attribute' => 'createdUserProfile.nomeCognome',

    ],
    'created_at:dateTime' => [
        'attribute' => 'created_at',
        'format' => 'datetime',
        'label' => Module::t('amosproject_management', 'Richiesta creata il')
    ],
    [
        'label' => Module::t('amosproject_management', 'Sent to validate first time'),
        'value' => function ($model) {
            /** @var $model \lispa\amos\projectmanagement\models\ProjectsModifyRequest */
            if (is_null($model->firstSendToValidate)) {
                return '';
            } else {
                return Yii::$app->formatter->asDatetime($model->firstSendToValidate);
            }
        }
    ],
    [
        'attribute' => 'status',
        'value' => 'workflowStatusLabel',
    ],
    [
        'class' => 'lispa\amos\core\views\grid\ActionColumn',
        'template' => '{read} {update} {delete}',
        'controller' => 'projects-modify-request',
        'buttons' => [
            'read' => function ($url, $model) use ($onlyView) {
                /** @var  $model */
                $btn = '';
                if (\Yii::$app->user->can('PROJECTSMODIFYREQUEST_READ', ['model' => $model])) {
                    $btn = Html::a(
                        \lispa\amos\core\icons\AmosIcons::show('file'),
                        ['/project_management/projects-modify-request/view', 'id' => $model->id],
                        [
                            'title' => Module::t('amosproject_management', 'Read'),
                            'model' => $model,
                            'class' => 'btn btn-tools-secondary'
                        ],
                        true
                    );
                }
                return !$onlyView ? $btn : '';
            },
            'update' => function ($url, $model) use ($onlyView) {
                /** @var  $model */
                $btn = '';
                if (\Yii::$app->user->can('PROJECTSMODIFYREQUEST_UPDATE', ['model' => $model])) {
                    $btn = Html::a(
                        \lispa\amos\core\icons\AmosIcons::show('edit'),
                        ['/project_management/projects-modify-request/update', 'id' => $model->id],
                        [
                            'title' => Module::t('amosproject_management', 'Update'),
                            'model' => $model,
                            'class' => 'btn btn-tools-secondary'
                        ],
                        true
                    );
                }
                return !$onlyView ? $btn : '';
            },
            'delete' => function ($url, $model) use ($onlyView) {
                /** @var  $model */
                $btn = '';
                if (\Yii::$app->user->can('PROJECTSMODIFYREQUEST_DELETE', ['model' => $model])) {
                    $btn = Html::a(
                        \lispa\amos\core\icons\AmosIcons::show('delete'),
                        ['/project_management/projects-modify-request/delete', 'id' => $model->id],
                        [
                            'title' => Module::t('amosproject_management', 'Delete'),
                            'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to delete this item?'),
                            'model' => $model,
                            'class' => 'btn btn-danger-inverse'
                        ],
                        true
                    );
                }
                return !$onlyView ? $btn : '';
            },
        ]
    ],
];

?>

<div>
    <?php
    try {
        $canCreateModify = !$onlyView && (isset($model) ? Yii::$app->user->can('ProjectsModifyRequestCreateRule', ['model' => $model]) : false);
        if (isset($availableViews) && $canCreateModify && !is_null($model->status) && $model->status != \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW_STATUS_STARTUP) {
            echo \lispa\amos\core\views\DataProviderView::widget([
                'dataProvider' => $modifyRequestDataProvider,
                //'filterModel' => $model,
                'gridView' => [
                    'columns' => $columns
                ],
                'availableViews' => $availableViews,
                'createNewBtnParams' => [
                    'createNewBtnLabel' => Module::t('amosproject_management', '#new_modify_request_btn'),
                    'urlCreateNew' => ['/project_management/projects-modify-request/create', 'pid' => $model->id],
                ],
                'currentView' => $currentView
            ]);
        } else {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $modifyRequestDataProvider,
                'columns' => $columns
            ]);
        }
    } catch (Exception $e) {
        pr($e->getMessage(), 'ERROR');
    }
    ?>
</div>