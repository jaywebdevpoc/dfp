<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsActivities $model
 */

$this->title = $model;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($project)];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects/by-project', 'pid' => $model->projects->id]
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model)];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Update');
?>
<div class="projects-activities-update">

    <?= $this->render('_form', [
        'model' => $model,
        'project' => $project,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
        'partecipants' => $partecipants,
    ]) ?>

</div>
