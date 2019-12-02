<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\search\ProjectsTasksSearch $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerJs("
            $('#projects-taskssearch-start_date').change(function(){
        if($('#projects-taskssearch-start_date').val() == ''){
        $('#projects-taskssearch-start_date-disp-kvdate .input-group-addon.kv-date-remove').remove();
        } else {
        if($('#projects-taskssearch-start_date-disp-kvdate .input-group-addon.kv-date-remove').length == 0){
        $('#projects-taskssearch-start_date-disp-kvdate').append('<span class=\"input-group-addon kv-date-remove\" title=\"Pulisci campo\"><i class=\"glyphicon glyphicon-remove\"></i></span>');
        initDPRemove('projects-taskssearch-start_date-disp');
        }
        }
        });
        ", yii\web\View::POS_READY);

?>
<div class="projects-tasks-search element-to-toggle" data-toggle-element="form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>

    <!-- name -->
    <div class="col-md-4"> <?=
        $form->field($model, 'name')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per name')
        ]) ?>

    </div>

    <!-- description -->
    <div class="col-md-4"> <?=
        $form->field($model, 'description')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per description')
        ]) ?>

    </div>


    <div class="col-md-4">
        <?=
        $form->field($model, 'attrProjectsActivitiesMm')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per activity')
        ])->label('Activity');
        ?>
    </div>

    <div class="col-md-4">
        <?=
        $form->field($model, 'attrOrganizationMm')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per reference  organization')
        ])->label('Reference Organization');
        ?>
    </div>

    <div class="col-md-4">
        <?=
        $form->field($model, 'attrProjectsTaskStatusesMm')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per status')
        ])->label('Status');
        ?>
    </div>
    <!-- start_date --><!-- DATE -->
    <div class="col-md-4">
        <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
            'options' => ['layout' => '{input} {picker} ' . (($model->start_date == '') ? '' : '{remove}')]
        ]); ?>
    </div>
    <!-- duration -->
    <div class="col-md-4"> <?=
        $form->field($model, 'duration')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per duration')
        ]) ?>

    </div>


    <div class="col-md-4">
        <?=
        $form->field($model, 'attrTasksMm')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per dependencies')
        ])->label('Dependencies');
        ?>
    </div>
    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <!--a><p class="text-center">Ricerca avanzata<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>
</div>
