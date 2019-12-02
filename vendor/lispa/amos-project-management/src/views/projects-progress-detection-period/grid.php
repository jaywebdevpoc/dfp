<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    grid.php
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;

?>

<?= DataProviderView::widget([
    'dataProvider' => $dataProvider,
    'availableViews' => $availableViews,
    'currentView' => $currentView,
    'createNewBtnParams' => [
        'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Period'),
        'urlCreateNew' => ['/project_management/projects-progress-detection-period/create', 'pid' => $project->id],
        'model' => new \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod(),
        'checkPermWithNewMethod' => !(Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])),
    ],
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
                'template' => '{read} {update} {delete} {view-progress}',
                'buttons' => [
                    'read' => function ($url, $model) use ($project) {
                        /** @var  $model */
                        $btn = '';
                        if(\Yii::$app->user->can('PROJECTSPROGRESSDETECTIONPERIOD_READ', ['model' => $model])){
                        $btn = Html::a(
                            \lispa\amos\core\icons\AmosIcons::show('file'),
                            [
                                '/project_management/projects-progress-detection-period/view',
                                'id' => $model->id,
                                'pid' => $project->id,
                            ],
                            [
                                'title' => Module::t('amosproject_management', 'Read'),
                                'model' => $model, // This model define if user is Community Manager
                                'class' => 'btn btn-tools-secondary'
                            ]
                        );
                    }
                    return $btn;
                    },
                    'view-progress' => function ($url, $model) use ($project) {
                        $url = null;
                        if ($model->status != \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED) {
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
                                    'pid' => $project->id,
                                ],
                                [
                                    'title' => Module::t('amosproject_management', 'See report'),
                                    'model' => $project, // This model define if user is Community Manager
                                    'class' => 'btn btn-tools-secondary'
                                ],
                                false
                            );
//                                    \yii\helpers\VarDumper::dump($btn,2,true);
                        }

                        return $btn;
                    },
                    'update' => function ($url, $model) use ($project) {
                        /** @var  $model */
                        $btn = '';
                        if(\Yii::$app->user->can('PROJECTSPROGRESSDETECTIONPERIOD_UPDATE', ['model' => $model])) {
                            $btn = Html::a(
                                \lispa\amos\core\icons\AmosIcons::show('edit'),
                                [
                                    '/project_management/projects-progress-detection-period/update',
                                    'id' => $model->id,
                                    'pid' => $project->id,
                                ],
                                [
                                    'title' => Module::t('amosproject_management', 'Update'),
                                    'model' => $model, // This model define if user is Community Manager
                                    'class' => 'btn btn-tools-secondary'
                                ]
                            );
                        }
                        return $btn;
                    },
                    'delete' => function ($url, $model) use ($project) {
                        /** @var  $model */
                        $btn = '';
                        if(\Yii::$app->user->can('PROJECTSPROGRESSDETECTIONPERIOD_DELETE', ['model' => $model])) {
                            $btn = Html::a(
                                \lispa\amos\core\icons\AmosIcons::show('delete'),
                                [
                                    '/project_management/projects-progress-detection-period/delete',
                                    'id' => $model->id,
                                    'pid' => $project->id,
                                ],
                                [
                                    'title' => Module::t('amosproject_management', 'Delete'),
                                    'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to delete this item?'),
                                    'model' => $model,
                                    'class' => 'btn btn-danger-inverse'
                                ],
                                false
                            );
                        }
                        return $btn;
                    },
                ]
            ],
        ],
    ],
]);
?>