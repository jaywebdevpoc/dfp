<?php

use lispa\amos\core\forms\AccordionWidget;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\TextEditorWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\ProjectsProgressCosts;
use lispa\amos\projectmanagement\models\ProjectsProgressCostsType;
use lispa\amos\projectmanagement\Module;
use kartik\select2\Select2;

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
}

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsProgressCosts $model
 * @var yii\widgets\ActiveForm $form
 */

$task = $model->projectsTask;
$canEdit = \lispa\amos\projectmanagement\utility\ProjectManagementUtility::isLoggedUserResponsibleTaskOrActivity($task);
$upRef = \lispa\amos\admin\models\UserProfile::find()->andWhere(['user_id' => $task->getUserResponsibleId()])->one();


$this->registerJs(/** @lang JavaScript 1.8 */
    <<<JS
//FirstTime calculate
recalculate();
JS
    , yii\web\View::POS_READY
);

?>

<?php $form = ActiveForm::begin(); ?>
<?php
try {
    echo \lispa\amos\workflow\widgets\WorkflowTransitionStateDescriptorWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => \lispa\amos\projectmanagement\models\ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW,
        'classDivIcon' => '',
        'classDivMessage' => 'message',
        'viewWidgetOnNewRecord' => true
    ]);
} catch (Exception $e) {
    pr($e->getMessage() . ' L:' . $e->getLine(), 'ERROR');
//    pr($e->getTraceAsString());
}
?>
<div class="projects-progress-costs-form col-xs-12 nop">

    <div class="row">
        <div class="col-xs-12">
            <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_progress_costs_activity') ?></h2>
        </div>
    </div>

    <div class="col-xs-12 nop">
        <div class="col-xs-12 info-project-progress-costs-area nop">
            <div class="col-xs-12 nop info-body">
                <div class="col-xs-12 nop">
                    <div class="col-lg-2 col-xs-6 nopl info-label"><?= $task->getAttributeLabel('name') ?></div>
                    <div class="col-lg-10 col-xs-6 nopl info-value"><?= $task->name ?></div>
                </div>
                <div class="col-xs-12 nop">
                    <div class="col-lg-2 col-xs-6 nopl info-label "><?= Module::t('amosproject_management', 'Description') ?></div>
                    <div class="col-lg-10 col-xs-6 nopl info-value"><?= $task->description ?></div>
                </div>
                <div class="col-xs-12 nop">
                    <div class="col-lg-2 col-xs-6 nopl info-label"><?= Module::t('amosproject_management', 'Start Date') ?></div>
                    <div class="col-lg-10 col-xs-6 nopl info-value"><?= Yii::$app->formatter->asDate($task->start_date) ?></div>
                </div>
                <div class="col-xs-12 nop">
                    <div class="col-lg-2 col-xs-6 nopl info-label"><?= Module::t('amosproject_management', 'End Date') ?></div>
                    <div class="col-lg-10 col-xs-6 nopl info-value"><?= Yii::$app->formatter->asDate($task->end_date) ?></div>
                </div>
                <div class="col-xs-12 nop">
                    <div class="col-lg-2 col-xs-6 nopl info-label"><?= Module::t('amosproject_management', 'Responsible') ?></div>
                    <div class="col-lg-10 col-xs-6 nopl info-value"><?= $upRef->getNomeCognome() ?></div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-8 col-xs-12 nop">
        <?= // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
        $form->field($model, 'projects_progress_cost_type_id')->widget(Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map(ProjectsProgressCostsType::find()->all(), 'id', 'nameTranslate'),
            'options' =>
                [
                    'placeholder' => Module::t('amosproject_management', 'Select...'),
                    'disabled' => !$canEdit
                ],

        ]);
        ?>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php $costs = ''; ?>

            <?php $costs .= '
                    <table class="table">
                    <thead class="thead-default">
                    <tr>
                    <th>
                    ' .
                Module::t('amosproject_management', 'Organization') .
                '</th>
                    <th>' .
                Module::t('amosproject_management', 'Total');
            ?>

            <?php
            foreach ($task->joinedOrganizations as $organization) {
                $costs .= '<th>' . $organization->name . '</th>';
            }
            ?>

            <?php
            $costs .= '</tr></thead><tbody>';
            ?>

            <?php
            foreach ($task->costItems as $costItem) {
                $costs .= '<tr><th scope="row">' .
                    $costItem->name .
                    '</th><th scope="row" class="text-center active">' .
                    Html::input('text', "total[{$costItem->id}]", 2, [
                        'data-item' => $costItem->id,
                        'class' => 'costsTotal form-control text-right',
                        'disabled' => true
                    ]) .
                    '</th>';

                foreach ($task->joinedOrganizations as $organization) {
                    /** @var \lispa\amos\projectmanagement\models\ProjectsTasksCosts $costRow */
                    $costRow = $task->getCostRow($costItem->id, $organization->id);

                    try {
                        $costs .= '<th>' .
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
                                'value' => (!is_null($costRow) ? $costRow->value : 0),
                                'disabled' => true,
                            ]) . '</th>';
                    } catch (Exception $e) {
                        pr($e->getMessage());
                    }
                }

                $costs .= '</tr>';
            }

            ?>

            <?php
            $costs .= '<tr><th scope="row">' .
                Module::t('amosproject_management', 'Total By Organization') .
                '</th><th scope="row" class="text-center active">' .
                Html::input('text', "total-all", 2, [
                    'class' => 'costsTotalAll form-control success text-right',
                    'disabled' => true
                ]) .
                '</th>';

            foreach ($task->joinedOrganizations as $organization) {
                $costs .= '<th class=" form form-group text-center active">' .
                    Html::input('text', "total-org[{$organization->id}]", 2, [
                        'data-organization' => $organization->id,
                        'class' => 'costsTotalOrg form-control text-right',
                        'disabled' => true
                    ]) .
                    '</th>';
            }
            $costs .= '</tr></tbody></table>';

            ?>

            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_progress_costs_summary'),
                        'content' => $costs,
                    ]
                ],
                'headerOptions' => ['tag' => 'h2'],
                'clientOptions' => [
                    'collapsible' => false,
                    'active' => false,
                    'icons' => [
                        'header' => 'ui-icon-amos am am-plus-square',
                        'activeHeader' => 'ui-icon-amos am am-minus-square',
                    ]
                ],
            ]);
            ?>

        </div>
    </div>

    <?php if ($canEdit) : ?>
        <div class="col-lg-8 col-xs-12 nop">
            <?= $form->field($model, 'note')->widget(TextEditorWidget::className(), [
                'clientOptions' => [
                    'placeholder' => Module::t('amosproject_management', 'Note'),
                    'lang' => substr(Yii::$app->language, 0, 2)
                ]
            ]) ?>
        </div>
    <?php else : ?>
        <div class="m-b-15">
            <?= $form->field($model, 'note')->hiddenInput([]) ?>
            <?= $model->note ?>
        </div>
    <?php endif; ?>

    <div class="col-xs-12 note_asterisk">
        <span><?= Module::t('amosproject_management', '#required_field') ?></span>
    </div>

    <div class="clearfix"></div>

    <?php
    $draftButtonsDefault = [
        'button' => Html::submitButton($model->isNewRecord ? Yii::t('amosnews', 'Crea') : Yii::t('amosnews', 'Salva'), ['class' => ($model->isNewRecord ? 'btn btn-navigation-primary' : 'btn btn-workflow')]),
        'description' => Yii::t('amosnews', 'il costo'),
    ];
    try {

        echo \lispa\amos\workflow\widgets\WorkflowTransitionButtonsWidget::widget([

            // parametri ereditati da verioni precedenti del widget WorkflowTransition
            'form' => $form,
            'model' => $model,
            'workflowId' => ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW,
            'viewWidgetOnNewRecord' => true,

            'closeButton' => Html::a(Yii::t('amosproject_management', 'Annulla'), Yii::$app->session->get('previousUrl') . '#costs', ['class' => 'btn btn-secondary']),

            // fisso lo stato iniziale per generazione pulsanti e comportamenti
            // "fake" in fase di creazione (il record non e' ancora inserito nel db)
            'initialStatusName' => "ONEDIT",
            'initialStatus' => ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT,

            // Setto e renderizzo il pulsante di salvataggio (quello che fa rimanere
            // nello stato in cui mi trovo) in modo diverso in base allo stato in cui mi trovo
            // in modo tale da creare descrizioni e label dei bottoni ad hoc in base allo stato
            // del workflow in cui mi trovo.

            // Il caso 'default' ?? obbligatorio e definisce il bottone "di default" da visualizzare
            // sempre con la sua description, l'array con chiave status (vedi esempio sotto) viene
            // richiamato solo quando il contenuto si trova nello stato definito esplicitamente

            'draftButtons' => [
                'default' => ($model->status == ProjectsProgressCosts::PROJECTSACTIVITYPROGRESS_WORKFLOW_STATUS_ONEDIT) ? $draftButtonsDefault : null
            ]
        ]);
    } catch (Exception $e) {
        pr($e->getMessage());
    }
    ?>
</div>

<?php ActiveForm::end(); ?>

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

            //currentTotalCosts.val(currentTotal.toFixed(2)).maskMoney({"prefix":"??? ","disabled":true});
            var currentTotalCostsValue = (currentTotal.toFixed(2)).replace(".", ",");
            currentTotalCostsValue = currentTotalCostsValue.substring(0, currentTotalCostsValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + currentTotalCostsValue.substring(currentTotalCostsValue.length - 3, currentTotalCostsValue.length);
            currentTotalCosts.val('??? ' + currentTotalCostsValue);
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

//            currentTotalCosts.val(currentTotal.toFixed(2)).maskMoney({"prefix":"??? ","disabled":true});
            var currentTotalValue = (currentTotal.toFixed(2)).replace(".", ",");
            currentTotalValue = currentTotalValue.substring(0, currentTotalValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + currentTotalValue.substring(currentTotalValue.length - 3, currentTotalValue.length);
            currentTotalCosts.val('??? ' + currentTotalValue);
        });

        //Set all total
        var allTotalValue = (allTotal.toFixed(2)).replace(".", ",");
        allTotalValue = allTotalValue.substring(0, allTotalValue.length - 3).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + allTotalValue.substring(allTotalValue.length - 3, allTotalValue.length);
        costTotalAllField.val('??? ' + allTotalValue);
    }
</script>
