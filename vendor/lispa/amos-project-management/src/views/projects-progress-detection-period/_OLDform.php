<?php

use lispa\amos\projectmanagement\models\ProjectsProgressDetectionType;
use lispa\amos\core\forms\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use lispa\amos\core\forms\Tabs;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use yii\helpers\Url;
use kartik\select2\Select2;
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
<?php

try {
    echo \lispa\amos\core\forms\WorkflowTransitionWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => \lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod::PROJECTSDETECTIONPERIOD_WORKFLOW,
        'classDivIcon' => 'pull-left',
        'classDivMessage' => 'pull-left message',
        'viewWidgetOnNewRecord' => true
    ]);
} catch (Exception $e) {
    pr($e->getMessage(), 'ERROR');
}
?>
    <div class="projects-progress-detection-period-form col-xs-12 nop">


        <?php $this->beginBlock('default'); ?>

        <div class="col-lg-12 col-sm-12">
            <?= $form->field($model, 'projects_progress_detection_type_id')->widget(\kartik\select2\Select2::className(), [
                'data' => \yii\helpers\ArrayHelper::map(ProjectsProgressDetectionType::find()->all(), 'id', 'NameTranslate'),
                'options' =>
                    [
                        'placeholder' => \lispa\amos\projectmanagement\Module::t('amosproject_management', 'Select...')
                    ]
            ]);
            ?>
        </div>
        <div class="col-lg-4 col-sm-4">
            <?= $form->field($model, 'warning_date')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE
            ]) ?>
        </div>

        <div class="col-lg-4 col-sm-4">

            <?= $form->field($model, 'start_date')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE
            ]) ?>
        </div>

        <div class="col-lg-4 col-sm-4">

            <?= $form->field($model, 'end_date')->widget(DateControl::className(), [
                'type' => DateControl::FORMAT_DATE
            ]) ?>
        </div>

        <div class="clearfix"></div>
        <?php $this->endBlock('default'); ?>

        <?php
        $itemsTab[] = [
            'label' => Yii::t('cruds', 'DEFAULT'),
            'content' => $this->blocks['default'],
        ];
        ?>

        <?php
        try {
            echo Tabs::widget(
                [
                    'encodeLabels' => false,
                    'items' => $itemsTab
                ]
            );
        } catch (Exception $e) {
        }
        ?>
        <?php
        try {
            echo CloseSaveButtonWidget::widget(['model' => $model]);
        } catch (Exception $e) {
        }
        ?>
    </div>
<?php ActiveForm::end(); ?>
