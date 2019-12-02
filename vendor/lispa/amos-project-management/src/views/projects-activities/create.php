<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsActivities $model
 */

$this->title = Module::t('amosproject_management', 'New Activity');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($project)];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects/by-project', 'pid' => $pid]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-activities-create">
    <?= $this->render('_form', [
        'model' => $model,
        'project' => $project,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
        'partecipants' => $partecipants,
//        'class' => $class,
    ]) ?>

</div>
