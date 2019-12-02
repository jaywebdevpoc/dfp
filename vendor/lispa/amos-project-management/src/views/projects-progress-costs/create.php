<?php

use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressCosts $model
*/

$this->title = Module::t('amosproject_management', 'Create {modelClass}', [
    'modelClass' => 'Projects Progress Costs',
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-progress-costs-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
