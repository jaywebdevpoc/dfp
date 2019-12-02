<?php

use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressStatements $model
*/

$this->title = Module::t('amosproject_management', 'Aggiorna {modelClass}', [
    'modelClass' => Module::t('amosproject_management', 'Projects Progress Statements'),
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Aggiorna');
?>
<div class="projects-progress-statements-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
