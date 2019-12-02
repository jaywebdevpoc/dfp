<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \lispa\amos\projectmanagement\models\search\ProjectsProgressCostsSearch $model
 */

$this->title = Yii::t('amosproject_management', 'Projects Progress Costs');
$this->params['breadcrumbs'][] = $this->title;

$this->params['textHelp']['filename'] = 'index_description';
?>

<?php
echo $this->render('../projects/_info_project_area', [
    'project' => $projects,
]);
?>

<div class="projects-progress-costs-index">
    <?php // echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a(Yii::t('cruds', 'Nuovo {modelClass}', [
    'modelClass' => 'Projects Progress Costs',
])        , ['create'], ['class' => 'btn btn-administration-primary'])*/ ?>
    </p>

    <?php

    try {
//        echo DataProviderView::widget([
//            'dataProvider' => $dataProvider,
//            //'filterModel' => $model,
//            'currentView' => $currentView,
//            'gridView' => [
//                'columns' => [
//                    'id',
//                    'status',
//                    'note:ntext',
//                    'projects_progress_costs_type_id',
//                    'projects_progress_detection_period_id',
//                    [
//                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
//                    ],
//                ],
//            ],
//        ]);

        $dp = new \lispa\amos\projectmanagement\models\ItemWorkPlanDataProvider([
            'projectId' => $projects->id,
            'pagination' => false,
        ]);

        lispa\amos\core\views\grid\CheckboxColumn::className();
        $request = $model;
        echo \lispa\amos\core\views\AmosGridView::widget([
            'dataProvider' => $dp,
            'columns' => [
                [
                    'label' => Module::t('amosproject_management', 'Type item'),
                    'value' => 'typeName',
                ],
                'name',
                [
                    'label' => Module::t('amosproject_management', 'Progress'),
                    'value' => function ($model) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                /** @var \lispa\amos\projectmanagement\models\ProjectsProgressCosts $projectCost */
                                $projectCost = $model->progressCostOnEdit;
                                try {
                                    return $projectCost->projectsProgressCostsType->nameTranslate;
                                } catch (Exception $e) {
                                    return '';
                                }
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => Module::t('amosproject_management', 'Status'),
                    'value' => function ($model) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                // $model now is Task
                                $projectCost = $model->progressCostOnEdit;
                                return empty($projectCost) ? '' : Module::t('amosproject_management', $projectCost->getWorkFlowStatus()->label);
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => Module::t('amosproject_management', 'Start Date'),
                    'value' => function ($model) {
                        try {
                            if (is_null($model->startDate)) {
                                return '';
                            } else {
                                return Yii::$app->formatter->asDate($model->startDate);
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                ],
                [
                    'label' => Module::t('amosproject_management', 'End Date'),
                    'value' => function ($model) {
                        try {
                            if (is_null($model->startDate)) {
                                return '';
                            } else {
                                return Yii::$app->formatter->asDate($model->endDate);
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                ],
                [
                    'label' => Module::t('amosproject_management', 'Last update'),
                    'value' => function ($model) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                // $model now is Task
                                $projectCost = $model->progressCostOnEdit;
                                return Yii::$app->formatter->asDatetime($projectCost->updated_at);
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'lispa\amos\core\views\grid\ActionColumn',
                    'template' => '{read} {update} {history}',
                    'buttons' => [
                        'read' => function ($url, $model) {
                            try {
                                /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                                if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                    // $model now is Task
                                    /** @var \lispa\amos\projectmanagement\models\ProjectsTasks $model */
                                    $projectCost = $model->progressCostOnEdit;
                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('file', ['class' => '']),
                                        ['/project_management/projects-progress-costs/view', 'id' => $projectCost->id],
                                        [
                                            'title' => Module::t('amosproject_management', 'Read'),
                                            'model' => $projectCost,
                                            'class' => 'btn btn-tools-secondary'
                                        ],
                                        true
                                    );
                                    return $btn;
                                } else {
                                    return '';
                                }
                            } catch (Exception $e) {
                                return '';
                            }
                        },
                        'update' => function ($url, $model) use ($projects) {
                            try {
                                /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                                if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                    // $model now is Task
                                    $projectCost = $model->progressCostOnEdit;
                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('edit', ['class' => '']),
                                        [
                                            '/project_management/projects-progress-costs/update',
                                            'id' => $projectCost->id,
                                            'pid' => $projects->id
                                        ],
                                        [
                                            'title' => Module::t('amosproject_management', 'update'),
                                            'model' => $projectCost,
                                            'class' => 'btn btn-tools-secondary'
                                        ],
                                        true
                                    );

                                    if (empty($btn)) {
                                        $can = Yii::$app->user->can(
                                            'PROJECTSPROGRESSCOSTS_UPDATE',
                                            [
                                                'title' => Module::t('amosproject_management', 'update'),
                                                'model' => $projectCost,
                                                'checkDate' => false,
                                            ]
                                        );

                                        if ($can) {
                                            $btn =  \lispa\amos\core\icons\AmosIcons::show(
                                                'edit', [
                                                'disabled' => true,
                                                'data-html' => 'true',
                                                'data-toggle' => 'tooltip',
                                                'title' => Module::t(
                                                    'amosproject_management',
                                                    'Update enabled from {startDate} to {endDate}', [
                                                    'startDate' => Yii::$app->formatter->asDate($projectCost->projectsProgressDetectionPeriod->start_date),
                                                    'endDate' => Yii::$app->formatter->asDate($projectCost->projectsProgressDetectionPeriod->end_date)
                                                ]),
                                            ]);
                                        }
                                    }

                                    return $btn;
                                } else {
                                    return '';
                                }
                            } catch (Exception $e) {
                                return '';
                            }
                        },
                        'history' => function ($url, $model) {
                            try {
                                /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                                if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('time', ['class' => '']),
                                        ['/project_management/projects-progress-costs/history-activity', 'tid' => $model->id],
                                        [
                                            'title' => Module::t('amosproject_management', 'History'),
                                            'class' => 'btn btn-tools-secondary'
                                        ],
                                        false
                                    );
                                    return $btn;
                                } else {
                                    return '';
                                }
                            } catch (Exception $e) {
                                return '';
                            }
                        }
                    ]
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage());
    }


    ?>

</div>
