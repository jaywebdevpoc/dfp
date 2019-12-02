<?php

use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTaskStatuses $model
 */

$this->title = strip_tags($model);
$this->params['breadcrumbs'][] = ['label' => 'Project Management', 'url' => ['/project_management']];
$this->params['breadcrumbs'][] = ['label' => 'Projects Task Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-task-statuses-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:html',
        ],
    ]) ?>

</div>

<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?= Html::a(Module::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?></div>
