<?php

use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model
 */

$this->title = Module::t('amosproject_management', 'Detection period');
$this->params['breadcrumbs'][] = ['label' => Yii::t('amosproject_management', 'Projects Progress Detection Period'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-progress-detection-period-view col-xs-12">

    <?php
    try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'value' => function ($model) {
                        return Yii::t('amosproject_management', $model->projectsProgressDetectionType->name);

                    },
                    'label' => Yii::t('amosproject_management', 'Type'),
                ],
                [
                    'attribute' => 'workflowStatusLabel',
                    'label' => Yii::t('amosproject_management', 'Status'),
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
                    'attribute' => 'percentageCompletitionString',
                    'label' => Yii::t('amosproject_management', 'Percentage of completion'),
                ],
//                'percentageCompletition',
//                'percentageCompletition:percent:0',

            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage(), 'ERROR');
    }
    ?>

    <div class="btnViewContainer pull-right">
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>    </div>

</div>
