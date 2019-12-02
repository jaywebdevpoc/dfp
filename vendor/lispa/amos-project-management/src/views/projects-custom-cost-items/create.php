<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices $model
 */

$projectId = Yii::$app->request->get('projects_id');
$project = \lispa\amos\projectmanagement\models\Projects::findOne($projectId);
$this->title = $project . " -  " . Module::t('amosproject_management', 'new cost item');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = [
    'label' => strip_tags($project),
    'url' => ['/project_management/projects/update', 'id' => $projectId, '#' => 'tab-cost-items']
];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'new cost item');
?>
<div class="projects-custom-cost-items-create">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
    ]) ?>

</div>
