<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model
 */

$this->title = Module::t('amosproject_management', 'Update Projects Progress Detection Period');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Progress Detection Period'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Aggiorna');
?>
<div class="projects-progress-detection-period-update">

    <?= $this->render('_form', [
        'model' => $model,
        'projects' => $projects,
    ]) ?>

</div>
