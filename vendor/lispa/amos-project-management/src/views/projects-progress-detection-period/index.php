<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \lispa\amos\projectmanagement\models\search\ProjectsProgressDetectionPeriodSearch $model
 */

$this->title = Module::t('amosproject_management', 'Detection periods');
$this->params['breadcrumbs'][] = $this->title;
/** @var \lispa\amos\projectmanagement\models\Projects $projects */
$projects = \Yii::$app->view->params['projects'];

$this->params['textHelp']['filename'] = 'index_description';
?>

<div class="projects-progress-detection-period-index">
    <?php
    echo $this->render('_search', ['model' => $model]);
    ?>
    <?php
    echo $this->render('../projects/_info_project_area', [
        'project' => $projects,
    ]);
    ?>
    <!--    <p>-->
    <?php /* echo         Html::a(Yii::t('cruds', 'Nuovo {modelClass}', [
    'modelClass' => 'Projects Progress Detection Period',
    ])        , ['create'], ['class' => 'btn btn-administration-primary'])*/ ?>
    <!--    </p>-->

    <?php
    //    pr($dataProvider->query->createCommand()->rawSql);
    try {
        echo DataProviderView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $model,
            'currentView' => $currentView,
            'gridView' => [
                'columns' => [
                    [
                        'attribute' => 'projects_progress_detection_type_id',
                        'value' => 'projectsProgressDetectionType.nameTranslate'
                    ],
                    [
                        'attribute' => 'warning_date',
                        'format' => 'date',
                    ],
                    [
                        'attribute' => 'start_date',
                        'format' => 'date',
                    ],
                    [
                        'attribute' => 'end_date',
                        'format' => 'date',
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Percentage of completion'),
                        'value' => function ($model) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model */
                            return (empty($model->percentageCompletition)) ? '0%' : $model->getPercentageCompletitionString();
                        }
                    ],
                    'status' => [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model */
                            return $model->hasWorkflowStatus() ? $model->workflowStatusLabel : '--';
                        }
                    ],
//                    'percentage_completition',
                    [
                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
                        'template' => '{read} {update} {view-progress} {delete}',
                        'buttons' => [
                            'read' => function ($url, $model) use ($projects) {
                                /** @var  $model */
                                $btn = Html::a(
                                    \lispa\amos\core\icons\AmosIcons::show('file'),
                                    [
                                        '/project_management/projects-progress-detection-period/view',
                                        'id' => $model->id,
                                        'pid' => $projects->id,
                                    ],
                                    [
                                        'title' => Module::t('amosproject_management', 'Read'),
                                        'model' => $projects, // This model define if user is Community Manager
                                        'class' => 'btn btn-tools-secondary'
                                    ],
                                    true
                                );
                                return $btn;
                            },
                            'view-progress' => function ($url, $model) use ($projects) {
                                $url = null;
//                                pr($model->status);
                                if ($model->status != ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED) {
                                    if ($model->projects_progress_detection_type_id == 1) {
                                        $url = '/project_management/projects-progress-statements/view-progress';
                                    }
                                    if ($model->projects_progress_detection_type_id == 2) {
                                        $url = '/project_management/projects-progress-costs/view-progress';
                                    }
                                }
                                $btn = '';

                                if (!is_null($url)) {
                                    /** @var  $model */
                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('eye'),
                                        [
                                            $url,
                                            'id' => $model->id,
                                            'pid' => $projects->id,
                                        ],
                                        [
                                            'title' => Module::t('amosproject_management', 'See report'),
                                            'model' => $projects, // This model define if user is Community Manager
                                            'class' => 'btn btn-tools-secondary'
                                        ],
                                        false
                                    );
//                                    \yii\helpers\VarDumper::dump($btn,2,true);
                                }

                                return $btn;
                            },
                            'update' => function ($url, $model) use ($projects) {
                                /** @var  $model */
                                $btn = Html::a(
                                    \lispa\amos\core\icons\AmosIcons::show('edit'),
                                    [
                                        '/project_management/projects-progress-detection-period/update',
                                        'id' => $model->id,
                                        'pid' => $projects->id,
                                    ],
                                    [
                                        'title' => Module::t('amosproject_management', 'Update'),
                                        'model' => $model, // This model define if user is Community Manager
                                        'class' => 'btn btn-tools-secondary'
                                    ],
                                    true
                                );
                                return $btn;
                            },
                            'delete' => function ($url, $model) use ($projects) {
                                /** @var  $model */
                                $btn = Html::a(
                                    \lispa\amos\core\icons\AmosIcons::show('delete'),
                                    [
                                        '/project_management/projects-progress-detection-period/delete',
                                        'id' => $model->id,
                                        'pid' => $projects->id,
                                    ],
                                    [
                                        'title' => Module::t('amosproject_management', 'Delete'),
                                        'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to delete this item?'),
                                        'model' => $model,
                                        'class' => 'btn btn-danger-inverse'
                                    ],
                                    true
                                );
                                return $btn;
                            },
                        ]
                    ],
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage());
        pr($e->getTraceAsString(), 'ERROR');
    }

    ?>

</div>
