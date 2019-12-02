<?php

use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\Projects $model
 */

$this->title = \lispa\amos\core\utilities\StringUtils::shortText($model->name, 100);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model)];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Update');
?>
<div class="projects-update">

    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
        'participantsDataProvider' => $participantsDataProvider,
        'organizationDataProvider' => $organizationDataProvider,
        'modifyRequestDataProvider' => $modifyRequestDataProvider,
    ]) ?>

</div>
