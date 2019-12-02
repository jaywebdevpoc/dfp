<?php

use lispa\amos\core\forms\editors\Select;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\controllers\ProjectsController;
use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerJs("
            $('#projectssearch-finish_date').change(function(){
        if($('#projectssearch-finish_date').val() == ''){
        $('#projectssearch-finish_date-disp-kvdate .input-group-addon.kv-date-remove').remove();
        } else {
        if($('#projectssearch-finish_date-disp-kvdate .input-group-addon.kv-date-remove').length == 0){
        $('#projectssearch-finish_date-disp-kvdate').append('<span class=\"input-group-addon kv-date-remove\" title=\"Pulisci campo\"><i class=\"glyphicon glyphicon-remove\"></i></span>');
        initDPRemove('projectssearch-finish_date-disp');
        }
        }
        });
        ", yii\web\View::POS_READY);

/** @var ProjectsController $appController */
$appController = Yii::$app->controller;

?>
<div class="projects-search element-to-toggle" data-toggle-element="form-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>
    <?= Html::hiddenInput("enableSearch", "1"); ?>

    <div class="col-xs-12">
        <h2 class="title">
            <?= Module::tHtml('amosproject_management', 'Search by'); ?>:
        </h2>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput([
            'placeholder' => Module::t('amosproject_management', 'Search by title')
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'project_measure_to_search')->widget(Select::className(), [
            'options' => [
                'placeholder' => Module::t('amoscore', 'Select/Choose'),
                'disabled' => false
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'data' => $appController->getProjectsMeasuresForSelect()
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'project_status')->widget(Select::className(), [
            'options' => [
                'placeholder' => Module::t('amoscore', 'Select/Choose'),
                'disabled' => false
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'data' => $appController->getProjectsWorkflowStatusesForSelect()
        ]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'start_date_from')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE
        ]); ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'start_date_to')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE
        ]); ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'finish_date_from')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE
        ]); ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'finish_date_to')->widget(DateControl::classname(), [
            'type' => DateControl::FORMAT_DATE
        ]); ?>
    </div>

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
