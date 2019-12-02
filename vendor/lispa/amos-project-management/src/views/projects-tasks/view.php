<?php

use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTasks $model
 */

$this->title = ($model->name);
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model->projectsActivities->projects)];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects-activities/by-project', 'pid' => $model->projectsActivities->projects->id]
];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
recalculate();
function recalculate() {
        console.log('ffff');
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
JS;
$this->registerJs($js);
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->project,
]); ?>

<div class="projects-tasks-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'name',
            'description:html',
            'referent' => [
                'attribute' => 'userReferent',
                'label' => Module::t('amosproject_management', 'Referent'),
            ],

            'organization' => [
                'attribute' => 'organization',
                'format' => 'html',
                'label' => Module::t('amosproject_management', 'Reference Organization'),
                'value' => $model->getattrOrganizationMm(),
            ],

            'userResponsibleCost' => [
                'attribute' => 'userResponsibleCosts.userProfile.nomeCognome',
                'label' => Module::t('amosproject_management', 'Consumo costi dichiarato da'),
            ],
            [
                'attribute' => 'start_date',
                'format' => [
                    'date',
                    (isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'
                ],
            ],
            [
                'attribute' => 'end_date',
                'format' => [
                    'date',
                    (isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y'
                ],
            ],
            'expDuration',
            'projectsActivities' => [
                'attribute' => 'projectsActivities',
                'format' => 'html',
                'label' => Module::t('amosproject_management', 'Work Package'),
                'value' => $model->getAttrProjectsActivitiesMm(),
            ],
//            'projectsTaskStatuses' => [
//                'attribute' => 'projectsTaskStatuses',
//                'format' => 'html',
//                'label' => Module::t('amosproject_management', 'Status'),
//                'value' => $model->getAttrProjectsTaskStatusesMm(),
//            ],


//            'duration',
//            'duration_scale',
        ],
    ]) ?>

    <div class="row">
        <div class="col-xs-12">
            <?php
            if (!$model->isNewRecord) {
                $dependencies = \lispa\amos\projectmanagement\widgets\DependenciesTasksWidget::widget([
                    'model' => $model,
                    'forceReadOnly' => true
                ]);
            } else {
                $dependencies = Module::t('amosproject_management', 'Save the task to enable this section');
            }
            ?>
            <?=
            $dependenciesSection = '<div class="col-xs-12 nop"><h2 class="subtitle-form">' .
                Module::t('amosproject_management', '#project_tasks_dependencies') .
                '</h2></div>' . $dependencies;
            ?>
        </div>
    </div>

    <?php if(\lispa\amos\projectmanagement\utility\ProjectManagementUtility::loggedUsedIsCommunityManager($model->projectsActivities->projects->community_id)){ ?>
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
                                        'onChange' => 'recalculate()',
                                        'disabled' => true

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
            <?= \lispa\amos\core\forms\AccordionWidget::widget([
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
<?php } ?>

<!--    --><?php //echo \lispa\amos\attachments\components\AttachmentsTable::widget([
//        'model' => $model,
//        'viewDeleteBtn' => Yii::$app->getUser()->can('PROJECTSTASKS_UPDATE', ['model' => $model]),
//        'attribute' => 'tasksAttachments'
//    ]) ?>

</div>



<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?= Html::a(Module::t('amoscore', 'Chiudi'), Yii::$app->session->get('previousUrl') . '#tab-tasks',
        ['class' => 'btn btn-secondary']); ?></div>

