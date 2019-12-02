<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsMeasure $model
 */

$this->title = 'Aggiorna';
$this->params['breadcrumbs'][] = ['label' => 'Project Management', 'url' => ['/project_management']];
$this->params['breadcrumbs'][] = ['label' => 'Projects Measure', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => strip_tags($model), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Aggiorna';
?>
<div class="projects-measure-update">

    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
    ]) ?>

</div>
