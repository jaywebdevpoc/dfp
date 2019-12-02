<?php

use lispa\amos\core\forms\AccordionWidget;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\AttachmentsWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTasks $model
 * @var yii\widgets\ActiveForm $form
 * @var lispa\amos\projectmanagement\models\ProjectsActivities $activity
 * @var array $partecipants
 */

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    // Layout
    lispa\amos\layout\assets\SpinnerWaitAsset::register($this);
} else {
    // Core
    \lispa\amos\core\views\assets\SpinnerWaitAsset::register($this);
}

$ajaxUrl = Url::to(['/project_management/projects-tasks/calculate-end-date']);

$this->registerJs(/** @lang JavaScript 1.8 */
    <<<JS
function calcEndDateHour(id) {
    var dataArray = {
        changedId: id,
        beginDate: $('#projectstasks-start_date').val(),
        lengthValue: $('#projectstasks-duration').val(),
        lengthMUId: $('#TaskLengthMeasurementUnit').val(),
        endDate: $('#projectstasks-end_date').val()
    };
    $.ajax({
        url: '$ajaxUrl',
        type: 'post',
        data: dataArray,
        dataType: 'json',
        success: function (response) {
            if (typeof response.changedId != 'undefined') {
                $('#projectstasks-start_date-disp').css("background-color", "white");
                $('#projectstasks-end_date-disp').css("background-color", "white");
                $('#TaskLengthMeasurementUnit').css("background-color", "white");
                $('#projectstasks-duration').css("background-color", "white");

                if (response.changedId) {
                    if ((response.changedId != 'projectstasks-start_date') && (response.startDatetime)) {
                        $('#projectstasks-start_date').val(response.startDatetime);
                        $('#projectstasks-start_date-disp').val(response.startDate);
                        $('#projectstasks-start_date-disp').css("background-color", "#ffff99");
                    }
                    if ((response.changedId != 'projectstasks-end_date') && (response.endDatetime)) {
                        $('#projectstasks-end_date').val(response.endDatetime);
                        $('#projectstasks-end_date-disp').val(response.endDate);
                        $('#projectstasks-end_date-disp').css("background-color", "#ffff99");
                    }
                    if ((response.changedId != 'projectstasks-duration') && (response.duration)) {
                        $('#projectstasks-duration').val(response.duration).trigger('change',[{myAction:true}]);
                        $('#projectstasks-duration').css("background-color", "#ffff99");

                    }
                    if ((response.changedId != 'TaskLengthMeasurementUnit') && (response.durationUnit)) {
                        $('#TaskLengthMeasurementUnit').val(response.durationUnit).trigger('change',[{myAction:true}]);
                        $('#TaskLengthMeasurementUnit').css("background-color", "#ffff99");
                    }
                }
            }
        },
        beforeSend: function () {
            $('.loading').show();
        },
        complete: function () {
            $('.loading').hide();
        }
    });
}

$('#projectstasks-start_date').on('change', function (event) {
    if ($(this).val()) {
        calcEndDateHour('projectstasks-start_date');
    }
});

$('#projectstasks-duration').on('change', function (event,data) {
    if ((typeof data != 'undefined') && data.myAction){
        return;
    }
    if ($(this).val()) {
        calcEndDateHour('projectstasks-duration');
    }
});

$('#TaskLengthMeasurementUnit').on('change', function (event,data) {
    if ((typeof data != 'undefined') && data.myAction){
        return;
    } 
    
    if (typeof data == 'undefined') {
        calcEndDateHour('TaskLengthMeasurementUnit');
    }
});

$('#projectstasks-end_date').on('change', function (event) {
    calcEndDateHour('projectstasks-end_date');
});

calcEndDateHour('nothing');

jQuery('.refference-button').on('click', function () {
    jQuery('input[name=\"ProjectsTasks[attrOrganizationMm]\"]').val(jQuery(this).data('id'));

    jQuery(this)
        .addClass('hidden')
        .siblings()
        .removeClass('hidden')
        .parents('tr')
        .siblings()
        .find('.refference-label')
        .removeClass('hidden')
        .addClass('hidden')
        .siblings()
        .removeClass('hidden');
});

//FirstTime calculate
recalculate();

$('#user-id').on('select2:select', function (e) {
    var data = e.params.data;
    if (!$('#user-responsible-costs-id').val()) {
        $('#user-responsible-costs-id').val(data.id).trigger('change.select2');;
    }
});

JS
    , yii\web\View::POS_READY
);

?>

<?= $this->render('../projects/_info_project_area', [
    'project' => ((!is_null($model->projectsActivities) && !is_null($model->projectsActivities->projects)) ? $model->projectsActivities->projects : $activity->projects),
]); ?>

<div class="loading" id="loader" hidden></div>
<div class="projects-tasks-form col-xs-12 nop">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'projects-tasks_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
            'enctype' => 'multipart/form-data',
//            'class' => ((isset($class)) ? $class : '')
        ]
    ]);
    ?>
    <div class="col-xs-12 nop">
        <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_tasks_general_settings') ?></h2>
    </div>
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <div class="col-lg-4 col-xs-12 nopl">
                <?= $form->field($model, 'attrUserMm')->widget(Select2::classname(), [
                    'data' => $partecipants,
                    'language' => 'it',
                    'options' => [
                        'multiple' => false,
                        'id' => 'user-id',
                        'placeholder' => Module::t('amosproject_management', 'Select/Choose') . '...',
                    ],
                ])
                ?>
            </div>
            <div class="col-lg-4 col-xs-12">
                <?= $form->field($model, 'attrOrganizationMm')->widget(DepDrop::classname(), [
//                    'data' => !empty($model->attrUserMm) ? null : null,
                    'options' => [
                        'id' => 'organization-id'
                    ],
                    'type' => DepDrop::TYPE_DEFAULT,
                    'pluginOptions' => [
                        'depends' => ['user-id'],
                        'placeholder' => Module::t('amosproject_management', 'Select/Choose') . '...',
                        'initialize' => true,
                        'url' => Url::to(['/project_management/projects/user-organizations']),
                        'params' => [
                            'organization-sel-id'
                        ]
                    ]
                ]);
                ?>
            </div>
            <div class="col-lg-4 col-xs-12 nopr">
                <?= $form->field($model, 'user_responsible_costs_id')->widget(Select2::classname(), [
                    'data' => $partecipants,
                    'language' => 'it',
                    'options' => [
                        'multiple' => false,
                        'id' => 'user-responsible-costs-id',
                        'placeholder' => Module::t('amosproject_management', 'Select/Choose') . '...',
                    ],
                ])
                ?>
            </div>
            <?= $form->field($model, 'description')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', 'Insert the task description'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
            <div class="col-lg-6 col-xs-6 nopl"><!-- start_date date -->
                <?= $form->field($model, 'start_date')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE
                ]) ?>
            </div>
            <div class="col-lg-6 col-xs-6 nopr"><!-- end_date date -->
                <?= $form->field($model, 'end_date')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE
                ]) ?>
            </div>
            <div class="col-xs-12 nop">
                <div class="col-lg-6 col-xs-6 nopl"><!-- duration decimal -->
                    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6 col-xs-6 nopr">
                    <?=
                    $form->field($model, 'duration_scale')->widget(Select2::className(), [
                        'data' => [
//                            'hours' => Module::t('amosproject_management', 'Hours'),
                            'days' => Module::t('amosproject_management', 'Days'),
                            'weeks' => Module::t('amosproject_management', 'Weeks'),
                            'months' => Module::t('amosproject_management', 'Months'),
                            'years' => Module::t('amosproject_management', 'Years'),
                        ],
                        'language' => substr(Yii::$app->language, 0, 2),
                        'options' => [
                            'id' => 'TaskLengthMeasurementUnit' . $fid,
                        ],
                    ])
                    ?>
                </div>
            </div>
            <?= $form->field($model, 'attrProjectsActivitiesMm')->hiddenInput()->label(false) ?>
            <?php
            $organizationId = 0;
            if (!empty($model->attrOrganizationMm)) {
                $organizationId = (is_object($model->attrOrganizationMm) ? $model->attrOrganizationMm->id : $model->attrOrganizationMm);
            } elseif (isset($model->organization)) {
                $organizationId = $model->organization->id;
            }
            ?>
            <?php if ($organizationId > 0): ?>
                <?= Html::hiddenInput('selected-sel-org', $organizationId, ['id' => 'organization-sel-id']); ?>
            <?php endif; ?>
        </div>

        <div class="col-lg-4 col-xs-12">
            <?= AttachmentsWidget::widget([
                'form' => $form,
                'model' => $model,
                'modelField' => 'tasksAttachments',
                'attachInputOptions' => [
                    'multiple' => true
                ],
                'attachInputPluginOptions' => [
                    'maxFileCount' => 100,
                    'showPreview' => false
                ],
            ]) ?>
        </div>

    </div>

    <div class="clearfix"></div>
    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                if (ProjectManagementUtility::getProjectTasksCount($model->project) < 2) {
                    $dependencies = Module::t('amosproject_management', '#dependencies_associa_one_task');
                } else {
                    $dependencies = \lispa\amos\projectmanagement\widgets\DependenciesTasksWidget::widget([
                        'model' => $model,
                    ]);
                }
            } else {
                $dependencies = Module::t('amosproject_management', 'Save the task to enable this section');
            }
            ?>
            <?=
            /*AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_tasks_dependencies'),
                        'content' => $dependencies,
                    ]
                ],
                'headerOptions' => ['tag' => 'h2'],
                'clientOptions' => [
                    'collapsible' => true,
                    'active' => false,
                    'icons' => [
                        'header' => 'ui-icon-amos am am-plus-square',
                        'activeHeader' => 'ui-icon-amos am am-minus-square',
                    ]
                ],
            ]);*/
            $dependenciesSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
                Module::t('amosproject_management', '#project_tasks_dependencies') .
                '</h2></div>' . $dependencies;
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                $widgetClassName = Module::getModuleOrganization()->getAssociateOrgsToProjectTaskWidgetClass();
                $participantsOrg = $widgetClassName::widget([
                    'model' => $model,
                    'permissions' => [
                        'add' => \lispa\amos\projectmanagement\rules\TaskOrganizationsMmRule::className(),
                    ],
                ]);
            } else {
                $participantsOrg = Module::t('amosproject_management', 'Save the task to enable this section');
            }
            ?>
            <?=
            /*AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_tasks_participants'),
                        'content' => $participantsOrg,
                    ]
                ],
                'headerOptions' => ['tag' => 'h2'],
                'clientOptions' => [
                    'collapsible' => true,
                    'active' => false,
                    'icons' => [
                        'header' => 'ui-icon-amos am am-plus-square',
                        'activeHeader' => 'ui-icon-amos am am-minus-square',
                    ]
                ],
            ]);*/
            $participantSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
                Module::t('amosproject_management', '#project_tasks_participants') .
                '</h2></div>' . $participantsOrg;
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $costs = '' ?>
            <?php if (!$model->isNewRecord) : ?>
                <?php if ($model->joinedOrganizations) : ?>

                    <?php $costs = '
                        <table class="table">
                        <thead class="thead-default">
                        <table class="table">
                        <thead class="thead-default">
                        <tr>
                        <th>
                        ' .
                        Module::t('amosproject_management', '#project_update_spending') .
                        '</th><th>' .
                        Module::t('amosproject_management', 'Total') .
                        '</th>';
                    foreach ($model->joinedOrganizations as $organization) :
                        $costs .= '<th>' . $organization->name . '</th>';
                    endforeach;

                    $costs = $costs . '
                        </tr>
                        </thead>
                        <tbody>';

                    foreach ($model->costItems as $costItem) :
                        $costs .= '<tr>
                                <th scope="row">' .
                            $costItem->name .
                            '</th>
                                <th scope="row" class="form form-group text-center active">' .
                            Html::input('text', "total[{$costItem->id}]", 2, [
                                'data-item' => $costItem->id,
                                'class' => 'costsTotal form-control text-right',
                                'disabled' => true
                            ]) .
                            '</th>';

                        foreach ($model->joinedOrganizations as $organization) :
                            /** @var \lispa\amos\projectmanagement\models\ProjectsTasksCosts $costRow */
                            $costRow = $model->getCostRow($costItem->id, $organization->id);

                            $costs .= '<th class="form form-group">' .
                                \kartik\money\MaskMoney::widget([
                                    'pluginOptions' => [
                                        'prefix' => html_entity_decode('&euro; '),
                                    ],
                                    'options' => [
                                        'data-item' => $costItem->id,
                                        'data-organization' => $organization->id,
                                        'class' => 'costsElement text-right',
                                        'onChange' => 'recalculate()'
                                    ],
                                    'name' => "projects_tasks_costs[{$organization->id}][{$costItem->id}]",
                                    'value' => (!is_null($costRow) ? $costRow->value : 0)
                                ]) .
                                '</th>';
                        endforeach;

                        $costs .= '</tr>';

                    endforeach;

                    $costs .= '
                    <tr><th scope="row" class="active">' .
                        Module::t('amosproject_management', 'Total By Organization') .
                        '</th><th scope="row" class="form form-group text-center active">' .
                        Html::input('text', "total-all", 2, [
                            'class' => 'costsTotalAll form-control success text-right',
                            'disabled' => true
                        ]) .
                        '</th>';

                    foreach ($model->joinedOrganizations as $organization) :

                        $costs .= '<th class=" form form-group text-center active">' .
                            Html::input('text', "total-org[{$organization->id}]", 2, [
                                'data-organization' => $organization->id,
                                'class' => 'costsTotalOrg form-control text-right',
                                'disabled' => true
                            ]) .
                            '</th>';
                    endforeach;

                    $costs .= '</tr></tbody></table>'
                    ?>
                <?php else: ?>
                    <?php $costs = Module::t('amosproject_management', 'Select organizations to join first') ?>
                <?php endif; ?>
            <?php else: ?>
                <?php $costs = Module::t('amosproject_management', 'Save the task to enable this section') ?>
            <?php endif; ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_tasks_costs'),
                        'content' => $costs,
                    ]
                ],
                'headerOptions' => ['tag' => 'h2'],
                'clientOptions' => [
                    'collapsible' => true,
                    'active' => false,
                    'icons' => [
                        'header' => 'ui-icon-amos am am-plus-square',
                        'activeHeader' => 'ui-icon-amos am am-minus-square',
                    ],
                ],
                'options' => [
                    'class' => 'first-accordion'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="row">

    </div>

    <div class="clearfix"></div>

    <?= CreatedUpdatedWidget::widget(['model' => $model, 'containerOptions' => ['class' => 'm-t-20']]) ?>
    <!--    --><?php //CloseSaveButtonWidget::widget([
    //        'model' => $model,
    //        'urlClose' => Yii::$app->session->get('previousUrl') . '#tab-tasks',
    //        'buttonNewSaveLabel' => Module::t('amosproject_management', 'Salva')
    //    ]); ?>
    <div class="workflow-transition-button-widget col-xs-12">
        <div class="workflow-buttons-container col-lg-10 col-lg-push-2 col-xs-12 nop">

            <div class="workflow-form-actions workflow-button-container">
                <?= Html::submitButton(Module::t('amosproject_management', 'Salva'), ['class' => 'btn btn-workflow']); ?>
                <p><?= Module::t('amosproject_management', 'Salva le modifiche e rimani nella scheda dell\'attività') ?></p>
            </div>
            <div class="workflow-form-actions workflow-button-container">
                <?= Html::submitButton(Module::t('amosproject_management', '#save_and_close'), ['class' => 'btn btn-workflow', 'name' => 'submit-button', 'value' => 'save_and_close']); ?>
                <p><?= Module::t('amosproject_management', 'Salva e vai al piano delle attività') ?></p>
            </div>
        </div>
        <div class="workflow-button-container col-lg-2 col-lg-pull-10 col-xs-12 nop">
            <?= Html::a(Yii::t('amoscore', 'Annulla'), Yii::$app->session->get('previousUrl') . '#tab-tasks', ['class' => 'btn btn-secondary undo-edit']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    function recalculate() {
        var costTotalFields = jQuery('.costsTotal');
        var costTotalOrgFields = jQuery('.costsTotalOrg');
        var costTotalAllField = jQuery('.costsTotalAll');

        //Summ every CostItemTotal
        var allTotal = 0;

        costTotalFields.each(function (key, currentTotalCostsObject) {
            var currentTotalCosts = jQuery(currentTotalCostsObject);
            var currentCostsRelated = jQuery('input.costsElement[data-item=' + currentTotalCosts.data('item') + '][type=hidden]');
            var currentTotal = 0;

            currentCostsRelated.each(function (skei, currentRelatedObject) {
                var currentRelated = jQuery(currentRelatedObject);
                currentRelatedVal = isNaN(parseFloat(currentRelated.val())) ? 0 : parseFloat(currentRelated.val());

                currentTotal = parseFloat(currentTotal) + parseFloat(currentRelatedVal);
            });

            //Set new total all
            allTotal = parseFloat(allTotal) + parseFloat(currentTotal);

            //currentTotalCosts.val(currentTotal.toFixed(2)).maskMoney({"prefix":"€ ","disabled":true});
            var currentTotalCostsValue = (currentTotal.toFixed(2)).replace(".", ",");
            currentTotalCostsValue = currentTotalCostsValue.substring(0, currentTotalCostsValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + currentTotalCostsValue.substring(currentTotalCostsValue.length - 3, currentTotalCostsValue.length);
            currentTotalCosts.val('€ ' + currentTotalCostsValue);
        });

        costTotalOrgFields.each(function (key, currentTotalCostsObject) {
            var currentTotalCosts = jQuery(currentTotalCostsObject);
            var currentCostsRelated = jQuery('input.costsElement[data-organization=' + currentTotalCosts.data('organization') + '][type=hidden]');
            var currentTotal = 0;

            currentCostsRelated.each(function (skei, currentRelatedObject) {
                var currentRelated = jQuery(currentRelatedObject);
                currentRelatedVal = isNaN(parseFloat(currentRelated.val())) ? 0 : parseFloat(currentRelated.val());

                currentTotal = parseFloat(currentTotal) + currentRelatedVal;
            });

//            currentTotalCosts.val(currentTotal.toFixed(2)).maskMoney({"prefix":"€ ","disabled":true});
            var currentTotalValue = (currentTotal.toFixed(2)).replace(".", ",");
            currentTotalValue = currentTotalValue.substring(0, currentTotalValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + currentTotalValue.substring(currentTotalValue.length - 3, currentTotalValue.length);
            currentTotalCosts.val('€ ' + currentTotalValue);
        });

        //Set all total
        var allTotalValue = (allTotal.toFixed(2)).replace(".", ",");
        allTotalValue = allTotalValue.substring(0, allTotalValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + allTotalValue.substring(allTotalValue.length - 3, allTotalValue.length);
        costTotalAllField.val('€ ' + allTotalValue);
    }
</script>
