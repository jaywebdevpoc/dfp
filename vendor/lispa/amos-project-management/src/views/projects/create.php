<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\Projects $model
 */

$this->title = Module::t('amosproject_management', 'New Project');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-create">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
//        'class' => $class,
        'participantsDataProvider' => $participantsDataProvider,
        'organizationDataProvider' => $organizationDataProvider,
        'modifyRequestDataProvider' => $modifyRequestDataProvider,
    ]) ?>

</div>
