<?php

use lispa\amos\core\helpers\Html;
use yii\widgets\ActiveForm;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionType;
use kartik\select2\Select2;
use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\search\ProjectsProgressDetectionPeriodSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="projects-progress-detection-period-search element-to-toggle" data-toggle-element="form-search">
    <div class="col-xs-12"><h2>Cerca per:</h2></div>
    <?php $form = ActiveForm::begin([
        'action' => [Yii::$app->controller->action->id, 'pid' => Yii::$app->request->get('pid')],
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    echo Html::hiddenInput("enableSearch", "1");
    echo Html::hiddenInput("currentView", Yii::$app->request->getQueryParam('currentView'));
    ?>
    <div class="col-sm-6 col-lg-4">
        <?php
        echo $form->field($model, 'projects_progress_detection_type_id')->widget(Select2::className(), [
            'data' => ArrayHelper::map(ProjectsProgressDetectionType::find()->all(), 'id', 'NameTranslate'),
            'options' =>
                [
                    'placeholder' => Module::t('amosproject_management', 'Select...')
                ]
        ]);
        ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?php
        echo $form->field($model, 'status_search')->widget(Select2::className(), [
            'data' => $model->getListOfStatusForFieds(),
            'options' =>
                [
                    'placeholder' => Module::t('amosproject_management', 'Select...')
                ]
        ]);
        ?>
    </div>
    <div class="col-sm-6 col-lg-4">
        <?php
        echo $form->field($model, 'start_date')->widget(DateControl::className(), [
            'type' => DateControl::FORMAT_DATE
        ]);
        ?>
    </div>
    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::a(Module::t('amoscore', 'Reset'), [Yii::$app->controller->action->id, 'pid' => Yii::$app->request->get('pid')], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(Module::t('amoscore', 'Search'), ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <!--a><p class="text-center">Ricerca avanzata<br>
                < ?=AmosIcons::show('caret-down-circle');?>
            </p></a-->
    <?php ActiveForm::end(); ?>

</div>
