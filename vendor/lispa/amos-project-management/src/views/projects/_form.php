<?php

use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\community\widgets\CommunityMembersWidget;
use lispa\amos\core\forms\AccordionWidget;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\editors\Select;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsMeasure;
use lispa\amos\projectmanagement\Module;
use lispa\amos\workflow\widgets\WorkflowTransitionButtonsWidget;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\Projects $model
 * @var yii\widgets\ActiveForm $form
 */

\lispa\amos\layout\assets\SpinnerWaitAsset::register($this);
\lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
$formId = '#projects_' . ((isset($fid)) ? $fid : 0);
$this->registerJs("
        $('#projects-finish_date" . ((isset($fid)) ? $fid : 0) . "').change(function(){
            if($('#projects-finish_date" . ((isset($fid)) ? $fid : 0) . "').val() == ''){
                $('#projects-finish_date" . ((isset($fid)) ? $fid : 0) . "-disp-kvdate .input-group-addon.kv-date-remove').remove();
            } else {
                if($('#projects-finish_date" . ((isset($fid)) ? $fid : 0) . "-disp-kvdate .input-group-addon.kv-date-remove').length == 0){
                    $('#projects-finish_date" . ((isset($fid)) ? $fid : 0) . "-disp-kvdate').append('<span class=\"input-group-addon kv-date-remove\" title=\"Pulisci campo\"><i class=\"glyphicon glyphicon-remove\"></i></span>');
                    initDPRemove('projects-finish_date" . ((isset($fid)) ? $fid : 0) . "-disp');
                }
            }
        });
        
        jQuery('.refference-button').on('click', function() {
            jQuery('input[name=\"Projects[attrOrganizationMm]\"]').val(jQuery(this).data('id'));
            
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
        
", yii\web\View::POS_READY);

$js = <<<JS

$("#sp-form").submit(function(e) { 
    if ($(this).data('submitted') === true) {
      // Previously submitted - don't submit again
      e.preventDefault();
      return false;
    } else {
      // Mark it so that the next submit can be ignored
      $(this).data('submitted', true);
    }
    var postdata = $(this).serializeArray();
    var formurl = $(this).attr("action");
     $('#new-cost-item-modal').modal('hide');
    $.ajax( {
        url : formurl,
        type: "POST", 
        data : postdata, 
        replace: false,
        push: false,
        container: '#spending-voice-form',// '#project-spending-voices',
        
        success:function(data, textStatus, jqXHR) { //data: returning of data from the server
            $("#sp-form").data('submitted', false);
            $('#projectscustomspendingvoices-name').val('');
            $('#save-cost-item').removeAttr('clicked').removeAttr('disabled');
            $("$formId button[type='submit']:first").removeAttr('disabled');
            $.ajax({
                url: 'spending-voices?id=$model->id',
                type: "POST",
                 replace: false,
                 push: false,
                container: "#project-spending-voices",
                success: function(response){
                    $('#sp-widget').html(response);
                }
            });
             e.preventDefault(); // default action us stopped here 
            return false;
        }, 
        error: function(jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown); 
        }
    });
    e.preventDefault(); // default action us stopped here 
    return false;
});

$('#sp-widget').bind("DOMSubtreeModified",function(){
    $('.loading').show();
      $.pjax.reload({container:"#pjax-costs-grid", timeout:20000})
      .done(function(){
          $('.loading').hide();
      });
});

JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>
<div class="loading" hidden></div>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'projects_' . ((isset($fid)) ? $fid : 0),
        'data-fid' => (isset($fid)) ? $fid : 0,
        'data-field' => ((isset($dataField)) ? $dataField : ''),
        'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
        'enctype' => 'multipart/form-data',
//            'class' => ((isset($class)) ? $class : '')
    ]
]);
?>

<?php
//pr(\Yii::$app->user->can('ProjectsWorkflow/ONEDIT'));
try {
    echo \lispa\amos\workflow\widgets\WorkflowTransitionStateDescriptorWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW,
        'classDivMessage' => 'message',
        'viewWidgetOnNewRecord' => true
    ]);
} catch (Exception $e) {
    pr($e->getMessage(), 'ERROR');
}
?>
<div class="projects-form col-xs-12 nop">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_update_general_settings') ?></h2>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-12 container-action-form">
                <?= Html::a(Module::t('amosproject_management', '#come_back'), ['/project_management/projects/by-project/', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
        <div class="col-lg-8 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint(Module::t('amosproject_management', '#project_name_field_hint')) ?>
            <?= $form->field($model, 'summary')->textInput(['maxlength' => true])->hint(Module::t('amosproject_management', '#project_summary_field_hint')) ?>
            <div class="col-lg-6 col-xs-12 nopl"><!-- finish_date date -->
                <?= $form->field($model, 'start_date')->widget(DateControl::className(), [
                    'options' => [
                        'id' => lcfirst(Inflector::id2camel(\yii\helpers\StringHelper::basename($model->className()),
                                '_')) . '-start_date',
                        'layout' => '{input} {picker} ' . (($model->finish_date == '') ? '' : '{remove}')
                    ]
                ]); ?></div>
            <div class="col-lg-6 col-xs-12 nopr"><!-- finish_date date -->
                <?= $form->field($model, 'finish_date')->widget(DateControl::className(), [
                    'options' => [
                        'id' => lcfirst(Inflector::id2camel(\yii\helpers\StringHelper::basename($model->className()),
                                '_')) . '-finish_date',
                        'layout' => '{input} {picker} ' . (($model->finish_date == '') ? '' : '{remove}')
                    ]
                ]); ?></div>
            <div class="col-lg-6 col-xs-12 nopl">
                <?php
                if (\Yii::$app->getUser()->can('PROJECTSMEASURE_CREATE')) {
                    $append = ' canInsert';
                } else {
                    $append = null;
                }
                ?>

                <?= $form->field($model, 'attrProjectsMeasureMm')->widget(Select::className(), [
                    'data' => ArrayHelper::map(ProjectsMeasure::find()->asArray()->all(), 'id', 'name'),
                    'language' => substr(Yii::$app->language, 0, 2),
                    'options' => [
                        'multiple' => false,
                        'id' => 'ProjectsMeasure' . ((isset($fid)) ? $fid : 0),
                        'placeholder' => 'Seleziona ...',
                        'class' => 'dynamicCreation' . $append,
                        'data-model' => 'projects_measure',
                        'data-field' => 'name',
                        'data-module' => 'project_management',
                        'data-entity' => 'projects-measure',
                        'data-toggle' => 'tooltip'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        "select2:open" => "dynamicInsertOpening"
                    ]
                ])
                ?>
            </div>
            <div class="col-lg-6 col-xs-12 nopr"><!-- website string -->
                <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
            </div>
            <?= $form->field($model, 'insights')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', '#insights_field_placeholder'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
        <div class="col-lg-4 col-xs-12">
            <?= $form->field($model, 'logo')->widget(\lispa\amos\attachments\components\AttachmentsInput::classname(), [
                'model' => $model,
                'options' => [ // Options of the Kartik's FileInput widget
                    'multiple' => false, // If you want to allow multiple upload, default to false
                    'accept' => "image/*"
                ],
                'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget
                    'allowedPreviewTypes' => ['image'],
                    'maxFileCount' => 1 // Client max files
                ]
            ])->hint(Module::t('amosproject_management', '#project_logo_hint')) ?>
            <?php if (false): ?>
                <?php
                $url = '/img/img_default.jpg';
                if (!is_null($model->community->communityLogo)) {
                    $url = $model->community->communityLogo->getUrl('square_large', false, true);
                }
                Yii::$app->imageUtility->methodGetImageUrl = 'getUrl';
                $roundImage = Yii::$app->imageUtility->getRoundImage($model->community->communityLogo);
                $logo = Html::img($url,
                    [
                        'class' => $roundImage['class'],
                        'style' => "margin-left: " . $roundImage['margin-left'] . "%; margin-top: " . $roundImage['margin-top'] . "%;",
                        'alt' => $model->getAttributeLabel('communityLogo')
                    ]);
                ?>
                <div class="container-round-img">
                    <?= $logo ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
//                $roles = $this->render('_tab_roles', [
//                    'model' => $model,
//                    'onlyView' => false,
//                ]) . "\n" .
                $roles = CommunityMembersWidget::widget([
                    'model' => $model,
                    'targetUrlParams' => [
                        'viewM2MWidgetGenericSearch' => true,
                        'userStatus' => CommunityUserMm::STATUS_ACTIVE
                    ],
                    'enableModal' => true,
                    'manageAttributesPermission' => 'PROJECT_MANAGER',
                    'addPermission' => 'PROJECT_MANAGER',
                    'communityManagerRoleName' => Projects::COMMUNITY_MANAGER_ROLE_NAME,
                    'delete_member_message' => Module::t('amosproject_management', '#delete_project_member'),
                ]);
            } else {
                $roles = Module::tHtml('amosproject_management', 'Save the project to enable this section');
            }
            ?>
            <?=
            /*AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_update_participants'),
                        'content' => $roles,
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
                Module::t('amosproject_management', '#project_update_participants') .
                '</h2></div>' . $roles;
            ?>
        </div>
    </div>
    <div class="row">

        <div id='sp-widget' class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                $spending = \lispa\amos\projectmanagement\widgets\ProjectSpendingVoicesWidget::widget([
                    'model' => $model
                ]);
            } else {
                $spending = Module::tHtml('amosproject_management', 'Save the project to enable this section');
            }
            ?>
            <?=
            /* AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_update_spending'),
                        'content' => $spending,
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
            ]); */
            $spendingSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
                Module::t('amosproject_management', '#project_update_spending') .
                '</h2></div>' . '<p>' . Module::t('amosproject_management', '#project_update_spending_subtitle1') . '</p>' . $spending;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <?php
            $organizations = $this->render('_tab_organizations', [
                'organizationDataProvider' => $organizationDataProvider,
                'projectId' => $model->id
            ]);
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_update_organizations'),
                        'content' => $organizations,
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
                'options' => [
                    'class' => 'first-accordion'
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                $modifyRequest = $this->render('_tab_modify_request', [
                    'modifyRequestDataProvider' => $modifyRequestDataProvider,
                    'onlyView' => false,
                ]);
            } else {
                $modifyRequest = Module::tHtml('amosproject_management', 'Save the project to enable this section');
            }
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_update_modify_request'),
                        'content' => $modifyRequest,
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
            ]); ?>
        </div>

        <?php \yii\widgets\Pjax::begin([
            'id' => 'pjax-costs-grid',
            'timeout' => 2000,
        ]) ?>
        <?php if (\lispa\amos\projectmanagement\utility\ProjectManagementUtility::loggedUsedIsCommunityManager($model->community_id)) { ?>
            <div id="table-costs" class="col-xs-12 m-t-0">
                <?php $costs = '';
                $costTotForRow = [];
                ?>
                <?php if (!$model->isNewRecord): ?>
                    <?php
                    $costs = '<table class="table"><thead class="thead-default"><tr><th>' .
                        Module::t('amosproject_management', '#project_update_spending') .
                        '</th>';

                    $workPackageOrganizations = $model->projectOrganizations;

                    foreach ($workPackageOrganizations as $organization) {
                        $costs .= '<th>' . $organization->name . '</th>';
                    }
                    $costs .= '<th>' . Module::t('amosproject_management', 'Totale per voce di spesa') . '</th>';
                    $costs .= '</tr>
                </thead>
                <tbody>';

                    $totalByOrg = [];

                    foreach ($model->projectsSpendingVoices as $costItem) {
                        $costs .= '<tr><th scope="row">' . $costItem->name . '</th>';
                        foreach ($workPackageOrganizations as $organization) {
                            $costRow = $model->getCostRow($costItem->id, $organization->id);
                            $totalByOrg[$organization->id] = isset($totalByOrg[$organization->id]) ? $totalByOrg[$organization->id] : 0;
                            $totalByOrg[$organization->id] += (float)$costRow['valueSumm'];
                            $costs .= '<th>' . Html::input('text', "total[{$costItem->id}]",
                                    '€ ' . round($costRow['valueSumm'], 2), [
                                        'class' => 'costsTotal form-control text-right',
                                        'disabled' => true
                                    ]) .
                                '</th>';
                            //for column cost total
                            if (empty($costTotForRow[$costItem->id])) {
                                $costTotForRow[$costItem->id] = 0;
                            }
                            $costTotForRow[$costItem->id] += round($costRow['valueSumm'], 2);
                        }
                        //column total cost
                        $costs .= '<th>' . Html::input('text', "total[{$costItem->id}]",
                                '€ ' . (!empty($costTotForRow[$costItem->id]) ? $costTotForRow[$costItem->id] : 0), [
                                    'class' => 'costsTotal form-control text-right',
                                    'disabled' => true
                                ]) . '</th>';
                        $costs .= '</tr>';
                    }
                    $costs .= '<tr><th scope="row">' . Module::t('amosproject_management', 'Total By Organization') . '</th>';
                    foreach ($workPackageOrganizations as $organization) {
                        $totalByOrg[$organization->id] = isset($totalByOrg[$organization->id]) ? $totalByOrg[$organization->id] : 0;
                        $costs .= '<th>' . Html::input('text', "total[{$organization->id}]",
                                '€ ' . round($totalByOrg[$organization->id], 2), [
                                    'class' => 'costsTotal form-control success text-right',
                                    'disabled' => true
                                ]) .
                            '</th>';
                    }

                    // row tot for organization, column total cost
                    $costs .= '<th>' . Html::input('text', "total[]",
                            '€ ' . array_sum($costTotForRow), [
                                'class' => 'costsTotal form-control text-right',
                                'disabled' => true
                            ]) . '</th>';

                    $costs .= '</tr></tbody></table>';

                    ?>
                <?php else: ?>
                    <?php $costs = Module::t('amosproject_management', 'Save the activity to enable this section'); ?>
                <?php endif; ?>

                <?= \lispa\amos\core\forms\AccordionWidget::widget([
                    'items' => [
                        [
                            'header' => Module::t('amosproject_management', '#project_activities_costs'),
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
                        ]
                    ],
                    'options' => [
                    ]
                ]); ?>
            </div>
        <?php } ?>
        <?php \yii\widgets\Pjax::end() ?>

    </div>

    <?= CreatedUpdatedWidget::widget(['model' => $model, 'containerOptions' => ['class' => 'm-t-20']]) ?>
    <?php

    $draftButtonsDefault = [
        'button' => Html::submitButton($model->isNewRecord ? Yii::t('amosproject_management', 'Salva') : Yii::t('amosproject_management', '#save_and_close'), [
            'class' => 'btn btn-workflow', 'name' => 'submit-button', 'value' => 'save_and_close'
        ]),
        'description' => Yii::t('amosproject_management', '#save_go_to_project_plan'),
    ];

    echo WorkflowTransitionButtonsWidget::widget([

        // parametri ereditati da verioni precedenti del widget WorkflowTransition
        'form' => $form,
        'model' => $model,
        'workflowId' => Projects::PROJECTS_WORKFLOW,
        'viewWidgetOnNewRecord' => true,

        'closeButton' => Html::a(Module::t('amosproject_management', 'Annulla'), \yii\helpers\Url::previous(), ['class' => 'btn btn-secondary']),

        // fisso lo stato iniziale per generazione pulsanti e comportamenti
        // "fake" in fase di creazione (il record non e' ancora inserito nel db)
        'initialStatusName' => "STARTUP",
        'initialStatus' => Projects::PROJECTS_WORKFLOW_STATUS_STARTUP,

        // Il caso 'default' è obbligatorio e definisce il bottone "di default" da visualizzare
        // sempre con la sua description, l'array con chiave status (vedi esempio sotto) viene
        // richiamato solo quando il contenuto si trova nello stato definito esplicitamente

        'additionalButtons' => [
            'default' => [
                [
                    'button' => Html::submitButton(Yii::t('amosproject_management', '#save'), ['class' => 'btn btn-workflow', 'name' => 'submit-button']),
                    'description' => Yii::t('amosproject_management', '#save_and_stay_in_update_project'),
                ],
            ]
        ],
        'draftButtons' => [
            'default' => ($model->status != Projects::PROJECTS_WORKFLOW_STATUS_VALIDATED) ? $draftButtonsDefault : (($model->getErrors('spending_voices') ? $draftButtonsDefault : null))
        ]
    ]); ?>


    <?php ActiveForm::end(); ?>

    <div id="spending-voice-form" data-pjax-container="spending-voice-form" data-pjax-timeout="10000">
        <?= $this->render('../projects-custom-cost-items/_formAjax', ['model' => new \lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices(), 'projectId' => $model->id]) ?>
    </div>

</div>
