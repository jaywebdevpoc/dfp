<?php

use yii\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
*/

$this->title = Module::t('amosproject_management', 'Aggiorna {modelClass}', [
    'modelClass' => Module::t('amosproject_management', 'Projects Modify Request'),
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Modify Request'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Aggiorna');
?>
<div class="projects-modify-request-update">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
