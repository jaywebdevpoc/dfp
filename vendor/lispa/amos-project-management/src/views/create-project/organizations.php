<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\Module;

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
        <div class="col-xs-12">
            <div class="pull-left">
                <div class="like-widget-img color-lightPrimary ">
                    <?= AmosIcons::show('group', [], 'dash'); ?>
                </div>
            </div>
            <div class="text-wrapper">
                <p><?= Module::tHtml('amosproject_management', 'Organizations') ?>
                </p>
            </div>
            <div class="col-lg-6 col-sm-6"><?php
                if (\Yii::$app->getUser()->can('AZIENDE_CREATE')) {
                    $append = ' canInsert';
                } else {
                    $append = null;
                }
                ?><?=
                $form->field($model, 'attrJoinedOrganizationsMm')->widget(\kartik\select2\Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map($organizationModelClass::find()->asArray()->all(),
                        'id', 'denominazione'),
                    'language' => 'it',
                    'options' => [
                        'multiple' => true,
                        'id' => 'JoinedOrganizations',
                        'placeholder' => Module::t('amosproject_management', 'Seleziona') . '...',
                        'class' => 'dynamicCreation' . $append,
                        'data-model' => 'aziende',
                        'data-field' => 'denominazione',
                        'data-module' => 'organizzazioni',
                        'data-entity' => 'aziende',
                        'data-toggle' => 'tooltip'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        "select2:open" => "dynamicInsertOpening"
                    ]
                ])->label(Module::t('amosproject_management', 'Joined Organizations'))
                ?> </div>
        </div>
    </div>
    <?= $form->field($model, 'id')->hiddenInput()->label('') ?>
</div>


<?= CloseSaveButtonWidget::widget([
    'model' => $model,
    'buttonCloseVisibility' => false,
    'buttonNewSaveLabel' => Module::tHtml('amosproject_management', 'Next'),
    'buttonSaveLabel' => Module::tHtml('amosproject_management', 'Next')
]); ?>
<?php ActiveForm::end(); ?>

