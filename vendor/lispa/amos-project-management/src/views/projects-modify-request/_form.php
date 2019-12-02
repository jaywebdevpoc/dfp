<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\views\projects-modify-request
 * @category   CategoryName
 */

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\ItemWorkPlanDataProvider;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use lispa\amos\workflow\widgets\WorkflowTransitionButtonsWidget;
use lispa\amos\workflow\widgets\WorkflowTransitionStateDescriptorWidget;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
 * @var yii\widgets\ActiveForm $form
 */

$allStatuses = $model->projects->getWorkflowSource()->getWorkflow(ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW)->getAllStatuses();

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
}

$currentUserId = Yii::$app->user->id;
$checkOwner = ($model->isNewRecord || ($model->created_by == $currentUserId));

?>

<?php $form = ActiveForm::begin(); ?>

<?php
if (!$model->isNewRecord) {
    echo WorkflowTransitionStateDescriptorWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW,
        'classDivIcon' => 'pull-left',
        'classDivMessage' => 'pull-left message',
        'viewWidgetOnNewRecord' => true
    ]);
}
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-modify-request-form col-xs-12 nop">

    <div class="col-lg-12 col-xs-12 nop">
        <?php

        if ($checkOwner) {
            $dp = new ItemWorkPlanDataProvider([
                'projectId' => $model->projects_id,
                'checkOwner' => (ProjectManagementUtility::loggedUserIsCommunityManager() ? false : $checkOwner),
                'pagination' => false,
            ]);

            try {
                lispa\amos\core\views\grid\CheckboxColumn::className();
                $request = $model;
                echo \lispa\amos\core\views\AmosGridView::widget([
                    'dataProvider' => $dp,
                    'columns' => [
                        [
                            'class' => 'lispa\amos\core\views\grid\CheckboxColumn',
                            'header' => 'Seleziona',
                            'checkboxOptions' => function ($model, $key, $index, $column) use ($request, $checkOwner) {
                                $stringId = StringHelper::basename($model->className()) . $model->id;
                                $checked = false;
                                /** @var \lispa\amos\projectmanagement\models\ProjectsAtModifyRequestMm $mmItem */
                                foreach ($request->projectsAtModifyRequestMms as $mmItem) {
                                    if ($stringId == $mmItem->getStringIdForForm()) {
                                        $checked = true;
                                    }
                                }
                                $disabled = !$checkOwner;//true;
//                            $idUserOwner = isset($request->created_by) ? $request->created_by : $currentUserId;
//                            if ($model instanceof ProjectsActivities) {
//                                if ($idUserOwner == $model->user->id) $disabled = false;
//                            }
//                            if ($model instanceof ProjectsTasks) {
//                                if ($idUserOwner == $model->user->id) $disabled = false;
//                            }
                                $display = true;
                                if ($model->typeName == 'WP') {
                                    $display = false;
                                }

                                return [
                                    'value' => $stringId,
                                    'checked' => $checked,
                                    'disabled' => $disabled,
                                    'title' => $disabled ?
                                        Module::t('amosproject_management',
                                            'You are not responsible for this Work Package, change request not allowed') :
                                        Module::t('amosproject_management', 'Seleziona'),
                                    'style' => $display ? [] : ['display' => 'none'],
                                ];
                            },
                        ],
                        [
                            'label' => Module::t('amosproject_management', 'Type item'),
                            //'value' => 'typeName',
                            'value' => function ($model) {
                                $retType = '';
                                if ($model instanceof ProjectsTasks) {
                                    $retType .= AmosIcons::show('long-arrow-return');
                                }
                                $retType .= $model->typeName;
                                return $retType;
                            },
                            'format' => 'raw'
                        ],
                        'name',
                        [
                            'label' => Module::t('amosproject_management', 'Start Date'),
                            'value' => function ($model) {
                                if (is_null($model->startDate)) {
                                    return '';
                                } else {
                                    return Yii::$app->formatter->asDate($model->startDate);
                                }
                            },
                        ],
                        [
                            'label' => Module::t('amosproject_management', 'End Date'),
                            'value' => function ($model) {
                                if (is_null($model->startDate)) {
                                    return '';
                                } else {
                                    return Yii::$app->formatter->asDate($model->endDate);
                                }
                            },
                        ],
                    ],
                ]);
            } catch (Exception $e) {
                pr($e->getMessage());
            }
        } else {
            echo $this->render('_list_of_selected', [
                'model' => $model,
            ]);
        }
        ?>
    </div>

    <div class="col-lg-12 col-xs-12 m-t-30 nop">
        <?= $form->field($model, 'description')->widget(TextEditorWidget::className(), [
            'clientOptions' => [
                'placeholder' => Module::t('amosproject_management', 'Insert the description'),
                'lang' => substr(Yii::$app->language, 0, 2)
            ]
        ]) ?>
    </div>

    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="clearfix"></div>

    <?= WorkflowTransitionButtonsWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW,
        'viewWidgetOnNewRecord' => true,
        'closeButton' => Html::a(Module::t('amoscore', 'Annulla'), Url::previous() . '#tab-modify-request', ['class' => 'btn btn-secondary']),


        'initialStatusName' => 'ONEDIT',
        'initialStatus' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT,
        'statusToRender' => [
            ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT => $allStatuses[ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_ONEDIT]->getLabel(),
            ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE => $allStatuses[ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE]->getLabel(),
            ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED => $allStatuses[ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED]->getLabel(),
        ],

        'hideSaveDraftStatus' => ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_VALIDATED,

//        'draftButtons' => [
//            ProjectsModifyRequest::PROJECTSMODIFYREQUEST_WORKFLOW_STATUS_TOVALIDATE => [
//                'button' => Html::submitButton(Module::t('amoscore', 'Salva'), ['class' => 'btn btn-workflow']),
//                'description' => 'le modifiche e mantieni la richiesta di modifica in modifica'
//            ],
//            'default' => [
//                'button' => Html::submitButton(Module::t('amosproject_management', 'Salva in bozza'), ['class' => 'btn btn-workflow']),
//                'description' => Yii::t('amosproject_management', 'Potrai confermare la richiesta in seguito'),
//            ]
//        ]
    ]); ?>

</div>
<?php
ActiveForm::end();
?>
