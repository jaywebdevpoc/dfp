<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\models\search\ProjectsProgressStatementsSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="projects-progress-statements-search element-to-toggle" data-toggle-element="form-search">
    <div class="col-xs-12"><h2>Cerca per:</h2></div>

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->controller->action->id,
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);

    echo Html::hiddenInput("enableSearch", "1");
    echo Html::hiddenInput("currentView", Yii::$app->request->getQueryParam('currentView'));
    ?>

    <div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'id') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'status') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'note') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'projects_progress_statements_type_id') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'projects_progress_detection_period_id') ?></div>    <?php // echo $form->field($model, 'projects_task_id') ?>

    <?php // echo $form->field($model, 'user_responsible_id') ?>

    <?php // echo $form->field($model, 'organization_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton(Module::t('amoscore', 'Reset'), ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(Module::t('amoscore', 'Search'), ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
<!--a><p class="text-center">Ricerca avanzata<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>

</div>
