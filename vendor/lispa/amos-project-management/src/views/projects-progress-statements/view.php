<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lispa\amos\projectmanagement\Module;
use yii\helpers\Url;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressStatements $model
*/

$this->title = Module::t('amosproject_management', 'Progress statement');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-progress-statements-view col-xs-12">

    <?php
    try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'workflowStatusLabel',
                    'label' => Yii::t('amosproject_management', 'Status'),
                ],
                'note:html',
                [
                    'label' => Module::t('amosproject_management', 'Progress statement'),
                    'attribute' => 'projectsProgressStatementsType.nameTranslate',
                ],
//                'projects_progress_detection_period_id',
                [
                    'label' => Module::t('amosproject_management', 'Activity'),
                    'attribute' => 'projectsTask.name',
                ],
                [
                    'label' => Module::t('amosproject_management', 'Responsible'),
                    'attribute'=>'userResponsible.id',
                ],
                [
                    'label' => Module::t('amosproject_management', 'Refference Organization'),
                    'attribute'=>'organizationResponsible',
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage(),'ERROR');
    } ?>

    <div class="btnViewContainer pull-right">
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>    </div>

</div>
