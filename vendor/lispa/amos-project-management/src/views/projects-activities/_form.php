<?php

use lispa\amos\core\forms\AccordionWidget;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var array $partecipants
 * @var lispa\amos\projectmanagement\models\ProjectsActivities $model
 * @var yii\widgets\ActiveForm $form
 * @var lispa\amos\projectmanagement\models\Projects $project
 * @var string $fid
 */

?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $project,
]); ?>

<div class="projects-activities-form col-xs-12 nop">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'projects-activities_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
        ]
    ]);
    ?>

    <div class="row">

        <div class="col-xs-12">
            <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_activities_general_settings') ?></h2>
        </div>

        <?php
        echo $form->field($model, 'attrProjectsMm')->hiddenInput()->label(false);
        if (isset($model->organization)) {
            echo Html::hiddenInput('selected-org', $model->organization->id, ['id' => 'organization-sel-id']);
        }
        ?>
        <div class="col-lg-12 col-xs-12 nop">
            <div class="col-lg-4 col-xs-12"><!-- name string -->
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-4 col-xs-12"><!-- partecipants string $partecipants -->
                <?= $form->field($model, 'attrUserMm')->widget(Select2::classname(), [
                    'data' => $partecipants,
                    'language' => 'it',
                    'options' => [
                        'multiple' => false,
                        'id' => 'user-id',
                        'placeholder' => Module::t('amosproject_management', 'Select/Choose') . '...',
                    ],
                ]) ?>
            </div>
            <div class="col-lg-4 col-xs-12">
                <?= $form->field($model, 'attrOrganizationMm')->widget(\kartik\depdrop\DepDrop::classname(), [
                    // 'data' => !empty($model->attrUserMm) ? null: null,
                    'options' => [
                        'id' => 'organization-id'
                    ],
                    'type' => \kartik\depdrop\DepDrop::TYPE_DEFAULT,
                    'pluginOptions' => [
                        'depends' => ['user-id'],
                        'placeholder' => Module::t('amosproject_management', 'Select/Choose') . '...',
                        'initialize' => true,
                        'url' => \yii\helpers\Url::to(['/project_management/projects/user-organizations']),
                        'params' => [
                            'organization-sel-id'
                        ]
                    ]
                ]); ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12"><!-- description text -->
            <?= $form->field($model, 'description')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', '#description_field_placeholder'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
    </div>

    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                $taskWidget = \lispa\amos\projectmanagement\widgets\ActivitiesTasksWidget::widget([
                    'model' => $model
                ]);
            } else {
                $taskWidget = Module::t('amosproject_management', 'Save the activity to enable this section');
            }
            ?>
            <?php
            /*AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_activities_tasks'),
                        'content' => $taskWidget,
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
            $tasksSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
                Module::t('amosproject_management', '#project_activities_tasks') .
                '</h2></div>' . $taskWidget;
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $costs = '';
            $costTotForRow = [];
            ?>
            <?php if (!$model->isNewRecord): ?>
                <?php
                $costs = '<table class="table"><thead class="thead-default"><tr><th>' .
                    Module::t('amosproject_management', '#project_update_spending') .
                    '</th>';

                $workPackageOrganizations = $model->projectActivityProjectTasksOrganizations;

                foreach ($workPackageOrganizations as $organization) {
                    $costs .= '<th>' . $organization->name . '</th>';
                }
                $costs .= '<th>'.Module::t('amosproject_management', 'Totale per voce di spesa').'</th>';
                $costs .= '</tr>
                </thead>
                <tbody>';

                $totalByOrg = [];

                foreach ($model->projects->projectsSpendingVoices as $costItem) {
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
                        if(empty($costTotForRow[$costItem->id])){
                            $costTotForRow[$costItem->id] = 0;
                        }
                        $costTotForRow[$costItem->id] += round($costRow['valueSumm'], 2);
                    }
                    //column total cost
                    $costs .= '<th>'. Html::input('text', "total[{$costItem->id}]",
                            '€ ' . (!empty($costTotForRow[$costItem->id]) ? $costTotForRow[$costItem->id] : 0) , [
                                'class' => 'costsTotal form-control text-right',
                                'disabled' => true
                            ]).'</th>';
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
                $costs .= '<th>'. Html::input('text', "total[]",
                        '€ ' . array_sum($costTotForRow), [
                            'class' => 'costsTotal form-control text-right',
                            'disabled' => true
                        ]).'</th>';

                $costs .= '</tr></tbody></table>';

                ?>
            <?php else: ?>
                <?php $costs = Module::t('amosproject_management', 'Save the work package to enable this section'); ?>
            <?php endif; ?>

            <?= AccordionWidget::widget([
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
                    'class' => 'first-accordion'
                ]
            ]); ?>
        </div>
    </div>

    <?= CreatedUpdatedWidget::widget(['model' => $model, 'containerOptions' => ['class' => 'm-t-20']]) ?> <div class="workflow-transition-button-widget col-xs-12">
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
<!--    --><?php //echo  CloseSaveButtonWidget::widget([
//        'model' => $model,
//        'urlClose' => ['/project_management/projects/by-project', 'pid' => $project->id],
//        'buttonNewSaveLabel' => Module::t('amosproject_management', 'Salva')
//    ]); ?>

    <?php ActiveForm::end(); ?>
</div>
