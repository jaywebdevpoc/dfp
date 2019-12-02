<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lispa\amos\projectmanagement\Module;
use yii\helpers\Url;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressCosts $model
*/

$this->title = Module::t('amosproject_management','Projects Progress Costs');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-progress-costs-view col-xs-12">

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
                        'label' => Module::t('amosproject_management', 'Cost statement'),
                    'attribute' => 'projectsProgressCostsType.nameTranslate',
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
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous(). '#costs', ['class' => 'btn btn-secondary']); ?>    </div>

</div>
