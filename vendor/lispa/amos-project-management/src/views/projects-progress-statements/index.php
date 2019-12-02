<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \lispa\amos\projectmanagement\models\search\ProjectsProgressStatementsSearch $model
 */

$this->title = Yii::t('amosproject_management', 'Projects Progress Statements');
$this->params['breadcrumbs'][] = $this->title;

$this->params['textHelp']['filename'] = 'index_description';
?>

<?php
echo $this->render('../projects/_info_project_area', [
    'project' => $projects,
]);
?>

<div class="projects-progress-statements-index">
    <?php // echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a(Yii::t('cruds', 'Nuovo {modelClass}', [
    'modelClass' => 'Projects Progress Statements',
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
//                    'projects_progress_statements_type_id',
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
                                return empty($projectStatement) ? '' : Module::t('amosproject_management', $projectStatement->getWorkFlowStatus()->label);
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
                                    if(!empty($projectStatement)) {

                                        $btn = Html::a(
                                            \lispa\amos\core\icons\AmosIcons::show('file', ['class' => '']),
                                            ['/project_management/projects-progress-statements/view', 'id' => $projectStatement->id],
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
                        'update' => function ($url, $model) use ($projects) {
                            try {
                                /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                                if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                    // $model now is Task
                                    /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $projectStatement */
                                    $projectStatement = $model->progressStatementOnEdit;
                                    $btn = '';
                                    if(!empty($projectStatement)) {
                                        $btn = Html::a(
                                            \lispa\amos\core\icons\AmosIcons::show('edit', ['class' => '']),
                                            [
                                                '/project_management/projects-progress-statements/update',
                                                'id' => $projectStatement->id,
                                                'pid' => $projects->id
                                            ],
                                            [
                                                'title' => Module::t('amosproject_management', 'update'),
                                                'model' => $projectStatement,
                                                'checkDate' => true,
                                                'class' => 'btn btn-tools-secondary',
                                            ],
                                            false
                                        );
                                        if (empty($btn)) {
                                            $can = Yii::$app->user->can(
                                                'PROJECTSPROGRESSSTATEMENTS_UPDATE',
                                                [
                                                    'title' => Module::t('amosproject_management', 'update'),
                                                    'model' => $projectStatement,
                                                    'checkDate' => false,
                                                ]
                                            );

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
                                        ['/project_management/projects-progress-statements/history-activity', 'tid' => $model->id],
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
