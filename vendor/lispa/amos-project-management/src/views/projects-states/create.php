<?php

use lispa\amos\core\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsStates $model
 */

$this->title = 'Crea';
$this->params['breadcrumbs'][] = ['label' => 'Project Management', 'url' => ['/project_management']];
$this->params['breadcrumbs'][] = ['label' => 'Projects States', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-states-create">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
    ]) ?>

</div>
