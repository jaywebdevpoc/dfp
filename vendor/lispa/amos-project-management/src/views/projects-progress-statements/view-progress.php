<?php

use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
}

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressStatements $model
 * @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $detectionPeriod
 */

$this->title = Module::t('amosproject_management', 'Projects Progress Statements');
$this->params['breadcrumbs'][] = ['label' => Yii::t('amosproject_management', 'Projects Progress Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-progress-statements-view col-xs-12">

    <?php
    try {
        $dp = new \lispa\amos\projectmanagement\models\ItemWorkPlanDataProvider([
            'projectId' => $projects->id,
            'pagination' => false,
        ]);

        lispa\amos\core\views\grid\CheckboxColumn::className();
        $detectionPeriod = $model;
        echo \lispa\amos\core\views\AmosGridView::widget([
            'dataProvider' => $dp,
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
                    'value' => function ($model) use ($detectionPeriod) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $projectStatement */
                                $projectStatement = $model->getProgressStatementOfDetection($detectionPeriod->id);
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
                    'value' => function ($model) use ($detectionPeriod) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                // $model now is Task
                                $projectStatement = $model->getProgressStatementOfDetection($detectionPeriod->id);
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
                    'value' => function ($model) use ($detectionPeriod) {
                        try {
                            /** @var \lispa\amos\projectmanagement\interfaces\ItemWorkPlanInterface $model */
                            if ($model->getClassPath() == \lispa\amos\projectmanagement\models\ProjectsTasks::className()) {
                                // $model now is Task
                                $projectStatement = $model->getProgressStatementOfDetection($detectionPeriod->id);
                                return Yii::$app->formatter->asDatetime($projectStatement->updated_at);
                            }
                        } catch (Exception $e) {
                            return '';
                        }
                    },
                    'format' => 'raw',
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage());
    }

    ?>

    <div class="btnViewContainer pull-right">
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>    </div>

</div>
