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
                        if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $projectStatement */
                            $projectStatement = $model->progressStatementOnEdit;
                            try {
                                return $projectStatement->projectsProgressStatementsType->nameTranslate;
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
                            $projectStatement = $model->progressStatementOnEdit;
                            return empty($projectStatement) ? '' : Module::t('amosproject_management',
                                $projectStatement->getWorkFlowStatus()->label);
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
                            $projectStatement = $model->progressStatementOnEdit;
                            return Yii::$app->formatter->asDatetime($projectStatement->updated_at);
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
                                $projectStatement = $model->progressStatementOnEdit;
                                if (!empty($projectStatement)) {

                                    $btn = Html::a(
                                        \lispa\amos\core\icons\AmosIcons::show('file', ['class' => '']),
                                        [
                                            '/project_management/projects-progress-statements/view',
                                            'id' => $projectStatement->id
                                        ],
                                        [
                                            'title' => Module::t('amosproject_management', 'Read'),
                                            'model' => $projectStatement,
                                            'class' => 'btn btn-tools-secondary'
                                        ],
                                        true
                                    );
                                    return $btn;
                                }
                            } else {
                                return '';
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                    'update' => function ($url, $model) use ($project) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                // $model now is Task
                                /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $projectStatement */
                                $projectStatement = $model->progressStatementOnEdit;
                                $btn = '';
                                if (!empty($projectStatement)) {
                                    $can = Yii::$app->user->can(
                                        'PROJECTSPROGRESSSTATEMENTS_UPDATE',
                                        [
                                            'title' => Module::t('amosproject_management', 'update'),
                                            'model' => $projectStatement,
                                            'checkDate' => true,
                                        ]
                                    );

                                    if($can) {
                                        $btn = Html::a(
                                            \lispa\amos\core\icons\AmosIcons::show('edit', ['class' => '']),
                                            [
                                                '/project_management/projects-progress-statements/update',
                                                'id' => $projectStatement->id,
                                                'pid' => $project->id
                                            ],
                                            [
                                                'title' => Module::t('amosproject_management', 'update'),
                                                'model' => $projectStatement,
                                                'class' => 'btn btn-tools-secondary',
                                            ]
                                        );
                                    }
                                    if (empty($btn)) {
                                        if ($can) {
                                            $btn = \lispa\amos\core\icons\AmosIcons::show(
                                                'edit', [
                                                'disabled' => true,
                                                'data-html' => 'true',
                                                'data-toggle' => 'tooltip',
                                                'title' => Module::t(
                                                    'amosproject_management',
                                                    'Update enabled from {startDate} to {endDate}', [
                                                    'startDate' => Yii::$app->formatter->asDate($projectStatement->projectsProgressDetectionPeriod->start_date),
                                                    'endDate' => Yii::$app->formatter->asDate($projectStatement->projectsProgressDetectionPeriod->end_date)
                                                ]),
                                            ]);
                                        }
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
                                    [
                                        '/project_management/projects-progress-statements/history-activity',
                                        'tid' => $model->id
                                    ],
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

