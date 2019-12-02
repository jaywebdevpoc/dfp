<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\editors\Select;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\models\ProjectsProgressDetectionType;
use lispa\amos\projectmanagement\Module;
use lispa\amos\workflow\widgets\WorkflowTransitionButtonsWidget;
use lispa\amos\workflow\widgets\WorkflowTransitionStateDescriptorWidget;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod $model
 * @var yii\widgets\ActiveForm $form
 */

$currentDate = date("d-m-Y");

$this->registerJs(<<<JS
    var currentDate = "$currentDate";
    jQuery(document).ready(function() {
      $("#projectsprogressdetectionperiod-warning_date-disp-kvdate").kvDatepicker('setStartDate', currentDate);
    });
JS
);

?>

<?php $form = ActiveForm::begin(); ?>

<?= WorkflowTransitionStateDescriptorWidget::widget([
    'form' => $form,
    'model' => $model,
    'workflowId' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW,
    'classDivIcon' => '',
    'classDivMessage' => 'message',
    'viewWidgetOnNewRecord' => true
]); ?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-progress-detection-period-form col-xs-12 nop">

    <div class="col-xs-12 nop">
        <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_detection_period_general_settings') ?></h2>
    </div>

    <div class="col-lg-5 col-sm-5 col-xs-12 nop">
        <?= $form->field($model, 'projects_progress_detection_type_id')->widget(Select::className(), [
            'data' => ArrayHelper::map(ProjectsProgressDetectionType::find()->all(), 'id', 'NameTranslate'),
            'options' => [
                'placeholder' => Module::t('amosproject_management', 'Select...')
            ]
        ]);
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-4 col-sm-4 nopl">
        <?= $form->field($model, 'warning_date')->widget(DateControl::className(), [
            'type' => DateControl::FORMAT_DATE
        ]) ?>
    </div>

    <div class="col-lg-4 col-sm-4">
        <?= $form->field($model, 'start_date')->widget(DateControl::className(), [
            'type' => DateControl::FORMAT_DATE
        ]) ?>
    </div>

    <div class="col-lg-4 col-sm-4 nopr">
        <?= $form->field($model, 'end_date')->widget(DateControl::className(), [
            'type' => DateControl::FORMAT_DATE
        ]) ?>
    </div>

    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="clearfix"></div>

    <?= WorkflowTransitionButtonsWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW,
        'viewWidgetOnNewRecord' => true,

        'closeButton' => Html::a(Yii::t('amosproject_management', 'Annulla'), Yii::$app->session->get('previousUrl') . '#detection-periods', ['class' => 'btn btn-secondary']),

        'initialStatusName' => "PLANNED",
        'initialStatus' => ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW_STATUS_PLANNED,

        'draftButtons' => [
            'default' => [
                'button' => Html::submitButton(Yii::t('amosnews', 'Salva'), ['class' => ($model->isNewRecord ? 'btn btn-navigation-primary' : 'btn btn-workflow')]),
                'description' => Yii::t('amosnews', 'il periodo di rilevazione'),
            ]
        ]
    ]); ?>

</div>
<?php ActiveForm::end(); ?>
