<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/* @var \lispa\amos\projectmanagement\models\Projects $model */

$this->title = Module::t('amosproject_management', 'New Project');
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Project'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$organizationModelClass = Module::getOrganizationModule()->getOrganizationModelClass();
?>

<?php
$form = ActiveForm::begin([
    'options' => [
        'id' => 'project_form_' . $model->id,
        'class' => 'form',
        'enctype' => 'multipart/form-data', //to load images
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
]);
?>

<div class="intro">
    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6 col-sm-6"><!-- summary string -->
            <?= $form->field($model, 'summary')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- insights text -->
            <?= $form->field($model, 'insights')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', '#insights_field_placeholder'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6">
            <?=
            $form->field($model, 'attrProjectsStatesMm')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\lispa\amos\projectmanagement\models\ProjectsStates::find()->asArray()->all(),
                    'id', 'name'),
                'language' => 'it',
                'options' => [
                    'multiple' => false,
                    'id' => 'ProjectsStates',
                    'placeholder' => Module::t('amosproject_management', 'Seleziona') . '...',
                    'data-model' => 'projects_states',
                    'data-field' => 'name',
                    'data-module' => 'project_management',
                    'data-entity' => 'projects-states',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Progress Status')
            ?>
        </div>
        <div class="col-lg-6 col-sm-6">
            <?= $form->field($model,
                'logo')->widget(\lispa\amos\attachments\components\AttachmentsInput::classname(), [
                'model' => $model,
                'options' => [ // Options of the Kartik's FileInput widget
                    'multiple' => true, // If you want to allow multiple upload, default to false
                ],
                'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget
                    'maxFileCount' => 10 // Client max files
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- finish_date date -->
            <?= $form->field($model, 'start_date')->widget(DateControl::classname(), [
                'options' => [
                    'id' => lcfirst(Inflector::id2camel(\yii\helpers\StringHelper::basename($model->className()),
                            '_')) . '-start_date',
                    'layout' => '{input} {picker} ' . (($model->finish_date == '') ? '' : '{remove}')
                ]
            ]); ?></div>
        <div class="col-lg-6 col-sm-6"><!-- finish_date date -->
            <?= $form->field($model, 'finish_date')->widget(DateControl::classname(), [
                'options' => [
                    'id' => lcfirst(Inflector::id2camel(\yii\helpers\StringHelper::basename($model->className()),
                            '_')) . '-finish_date',
                    'layout' => '{input} {picker} ' . (($model->finish_date == '') ? '' : '{remove}')
                ]
            ]); ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><?php
            if (\Yii::$app->getUser()->can('AZIENDE_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = null;
            }
            ?><?=
            $form->field($model, 'attrOrganizationMm')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($organizationModelClass::find()->asArray()->all(),
                    'id', 'denominazione'),
                'language' => 'it',
                'options' => [
                    'multiple' => false,
                    'placeholder' => Module::t('amosproject_management', 'Seleziona') . '...',
                    'class' => 'dynamicCreation' . $append,
                    'data-field' => 'denominazione',
                    'data-module' => 'organizzazioni',
                    'data-entity' => 'aziende',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                //'pluginEvents' => [
                //    "select2:open" => "dynamicInsertOpening"
                //]
            ])->label(Module::t('amosproject_management', 'Leader Organization'))
            ?> </div>
        <div class="col-lg-6 col-sm-6">
            <?php
            if (\Yii::$app->getUser()->can('AZIENDE_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = null;
            }
            ?>
            <?=
            $form->field($model, 'attrProjectsMeasureMm')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\lispa\amos\projectmanagement\models\ProjectsMeasure::find()->asArray()->all(),
                    'id', 'name'),
                'language' => 'it',
                'options' => [
                    'multiple' => true,
                    'placeholder' => Module::t('amosproject_management', 'Seleziona') . '...',
                    'class' => 'dynamicCreation' . $append,
                    'data-model' => 'project_measure',
                    'data-field' => 'name',
                    'data-entity' => 'project_measure',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                //'pluginEvents' => [
                //    "select2:open" => "dynamicInsertOpening"
                //]
            ])->label(Module::t('amosproject_management', 'Project Measure'))
            ?> </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- website string -->
            <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="clearfix"></div>

</div>


<?= CloseSaveButtonWidget::widget([
    'model' => $model,
    'buttonCloseVisibility' => false,
    'buttonNewSaveLabel' => Module::tHtml('amosproject_management', 'Next'),
    'buttonSaveLabel' => Module::tHtml('amosproject_management', 'Next')
]); ?>
<?php ActiveForm::end(); ?>

