<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\Tabs;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTaskStatuses $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="projects-task-statuses-form col-xs-12 nop">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'projects-task-statuses_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
            'class' => ((isset($class)) ? $class : '')
        ]
    ]);
    ?>
    <?php // $form->errorSummary($model, ['class' => 'alert-danger alert fade in']); ?>
    <?php $this->beginBlock('generale'); ?>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- name string -->
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-12 col-sm-12"><!-- description text -->
            <?= $form->field($model, 'description')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', '#description_field_placeholder'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
    </div>
    <div class="clearfix"></div><?php $this->endBlock(); ?><?php $itemsTab[] = [
        'label' => Module::t('amosproject_management', 'Generale'),
        'content' => $this->blocks['generale'],
    ];
    ?>

    <?= Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]
    );
    ?>
    <?= CreatedUpdatedWidget::widget(['model' => $model,'containerOptions' => ['class' => 'm-t-20']]) ?>
    <?= CloseSaveButtonWidget::widget(['model' => $model]); ?>
    <?php ActiveForm::end(); ?>
</div>
