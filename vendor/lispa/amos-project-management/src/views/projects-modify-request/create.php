<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
 */

$this->title = Module::t('amosproject_management', 'Create Projects Modify Request', [
    'modelClass' => 'Projects Modify Request',
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Modify Request'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-modify-request-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
