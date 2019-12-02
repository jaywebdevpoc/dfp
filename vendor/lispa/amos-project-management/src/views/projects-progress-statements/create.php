<?php

use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressStatements $model
*/

$this->title = Module::t('amosproject_management', 'Create {modelClass}', [
    'modelClass' => Module::t('amosproject_management', 'Projects Progress Statements'),
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-progress-statements-create">
    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
