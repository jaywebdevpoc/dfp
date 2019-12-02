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
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\Module;

?>

<?= DataProviderView::widget([
    'dataProvider' => $dataProvider,
    'currentView' => $currentView,
//    'availableViews' => $availableViewsCosts,
    'gridView' => [
        'columns' => [
            [
                'label' => Module::t('amosproject_management', 'Type item'),
                //'value' => 'typeName',
                'value' => function ($model) {
                    $retType = '';
                    if ($model instanceof \lispa\amos\projectmanagement\models\ProjectsTasks) {
                        $retType .= \lispa\amos\core\icons\AmosIcons::show('long-arrow-return');
                    }
                    $retType .= $model->typeName;
                    return $retType;
                },
                'format' => 'raw'
            ],
            'name',
            [
                'label' => Module::t('amosproject_management', 'Progress'),
                'value' => function ($model) {
                    try {
                        /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                        if ($model->getClassPath() == ProjectsTasks::className()) {
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
                        if ($model->getClassPath() == ProjectsTasks::className()) {
                            // $model now is Task
                            $projectCost = $model->progressCostOnEdit;
                            return empty($projectCost) ? '' : Module::t('amosproject_management', $projectCost->workflowStatus->label);
                        }
                    } catch (Exception $e) {
                        return '';
                    }
                    return '';

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
                'template' => '{read} {update}  {history}',
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
                    'update' => function ($url, $model) use ($project) {
                        $btn = '';
                        /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                        if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                            // $model now is Task
                            /** @var  ProjectsTasks $model */
                            $projectCost = $model->progressCostOnEdit;
                            if (!is_null($projectCost)) {
                                $can = Yii::$app->user->can(
                                    'PROJECTSPROGRESSCOSTS_UPDATE',
                                    [
                                        'title' => Module::t('amosproject_management', 'update'),
                                        'model' => $projectCost,
                                        'checkDate' => true,
                                    ]
                                );
                                if($can) {
                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('edit', ['class' => '']),
                                        [
                                            '/project_management/projects-progress-costs/update',
                                            'id' => $projectCost->id,
                                            'pid' => $project->id
                                        ],
                                        [
                                            'title' => Module::t('amosproject_management', 'update'),
                                            'model' => $projectCost,
                                            'class' => 'btn btn-tools-secondary'
                                        ]
                                );
                                }

                                if (empty($btn) && $can) {
                                    $btn = \lispa\amos\core\icons\AmosIcons::show(
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
                        }
                        return $btn;
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
    ]
]);
?>

