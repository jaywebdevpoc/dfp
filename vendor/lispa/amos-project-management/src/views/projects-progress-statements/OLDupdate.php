<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressStatements $model
*/

$this->title = Yii::t('cruds', 'Aggiorna {modelClass}', [
    'modelClass' => 'Projects Progress Statements',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('cruds', 'Projects Progress Statements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('cruds', 'Aggiorna');
?>
<div class="projects-progress-statements-update">

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
