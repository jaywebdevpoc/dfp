<?php

use lispa\amos\core\helpers\Html;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model
*/

$this->title = Yii::t('amosproject_management', 'Create Projects Progress Detection Period', [
    'amosproject_management' => 'Projects Progress Detection Period',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('amosproject_management', 'Projects Progress Detection Period'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-progress-detection-period-create">
    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
