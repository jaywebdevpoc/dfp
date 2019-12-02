<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTasks $model
 * @var \lispa\amos\projectmanagement\models\ProjectsActivities $activity
 */

$this->title = Module::t('amosproject_management', 'New task');
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['/project_management']];
$this->params['breadcrumbs'][] = ['label' => strip_tags($activity->projects)];
$this->params['breadcrumbs'][] = [
    'label' => 'Project Activities',
    'url' => ['/project_management/projects-activities/by-project', 'pid' => $activity->projects->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-tasks-create">
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
