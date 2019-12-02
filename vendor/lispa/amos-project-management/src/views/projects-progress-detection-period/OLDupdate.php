<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model
 */

$this->title = Yii::t('amosproject_management', 'Update Projects Progress Detection Period');
$this->params['breadcrumbs'][] = ['label' => Yii::t('amosproject_management', 'Projects Progress Detection Period'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cruds', 'Aggiorna');
?>
<div class="projects-progress-detection-period-update">

    <?= $this->render('_form', [
        'model' => $model,
        'projects' => $projects,
    ]) ?>

</div>
