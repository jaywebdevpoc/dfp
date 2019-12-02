<?php

use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressCosts $model
*/

$this->title = Module::t('amosproject_management', 'Update Projects Progress Costs');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Costs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Aggiorna');
?>
<div class="projects-progress-costs-update">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
