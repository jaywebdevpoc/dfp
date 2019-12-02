<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTasks $model
 * @var \lispa\amos\projectmanagement\models\base\ProjectsActivities $activity
 */

$this->title = $model;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($activity->projects)];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects-activities/by-project', 'pid' => $activity->projects->id]
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model)];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Update');
?>
<div class="projects-tasks-update">

    <?= $this->render('_form', [
        'model' => $model,
        'activity' => $activity,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
        'partecipants' => $partecipants,
//        'class' => $class,
    ]) ?>

</div>
