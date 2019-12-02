<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsMeasure $model
 */

$this->title = Module::t('amosproject_management', '#create_project_measure_title');
?>
<div class="projects-measure-create">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
    ]) ?>

</div>
