<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\forms\PMButtons;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;

/**
 * @var \yii\web\View $this
 * @var Projects $project
 * @var yii\data\ActiveDataProvider $dataProviderActivities
 * @var array $currentViewActivities
 * @var array $availableViewsActivities
 */

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
}

$this->title = $project->name;
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_info_project_area', [
    'project' => $project,
]); ?>

<!--< ?php-->
<!--if (Yii::$app->controller->action->id != 'by-project'):-->
<!--    ?>-->
<!--    <div class="projects-activities-index">-->
<!--        <div class="col-xs-2 container-secondary-actions nop">-->
<!--            < ?php-->
<!--            echo Html::a(Module::t('amosproject_management', 'Return to the Work Package'),-->
<!--                ['/project_management/projects-activities/by-project', 'pid' => $project->id],-->
<!--                ['class' => 'btn btn-primary'])-->
<!--            ?>-->
<!--        </div>-->
<!--    </div>-->
<!--    < ?php-->
<!--endif;-->
<!--?>-->
<div class="clearfix"></div>
<?php $this->beginBlock('activities'); ?>
<?php
$dataProviderViewWidgetConf = [
    'dataProvider' => $dataProviderActivities,
    'currentView' => $currentViewActivities,
    'availableViews' => $availableViewsActivities,
    'forceCreateNewButtonWidget' => true,
    'gridView' => [
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'startDate:date',
            'endDate:date',
            'duration',
            'user' => [
                'attribute' => 'user',
                'format' => 'html',
                'label' => Module::t('amosproject_management', 'Reference User'),
                'value' => function ($model) {
                    return strip_tags($model->getAttrUserMm(','));
                }
            ],
            'organization' => [
                'attribute' => 'organization',
                'format' => 'html',
                'label' => Module::t('amosproject_management', 'Leader Organization WP'),
                'value' => function ($model) {
                    return strip_tags($model->getAttrOrganizationMm(','));
                }
            ],
            //'status',
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'Tasks',
                'allowBatchToggle' => false,
                'header' => Module::t('amosproject_management', 'Expand / Collapse'),
                'headerOptions' => [
                    'style' => 'white-space: nowrap;'
                ],
                'contentOptions' => [
                    'class' => 'text-center'
                ],
                'value' => function ($model, $key, $index, $column) {
                    return \kartik\grid\GridView::ROW_COLLAPSED;
                },
                'detailUrl' => \yii\helpers\Url::to(['/project_management/projects-tasks/list-only'])
            ],
            [
                'class' => \lispa\amos\core\views\grid\ActionColumn::className(),
                'controller' => 'projects-activities',
                'buttonClass' => PMButtons::className(),
            ],
        ],
    ],
    'ganttView' => [
        'model' => $project,
        'clientOptions' => [
            'config' => [
                // ERRORS DISABLED POII-693
                'show_errors' => false,
            ],
            'templates' => [
                'grid_file' => new \yii\web\JsExpression('
                            function(item) {
                            console.log(item);
                                return  "<div class=\'gantt_tree_icon\'>"+item.custom.relationError+"</div>" + "<div class=\'gantt_tree_icon gantt_file\'></div>";
                            };
                        '),
                'tooltip_text' => new \yii\web\JsExpression('
                            function(start,end,task) {
                                // console.log(task)
                                var type = task.type.split(/[. ]+/).pop();
                                type = type[0].toUpperCase() + type.substr(1);
                                return  "<b>"+type+":</b> "+task.text+"<br/><b>Organization:</b>  "+task.custom.organization+"<br/><b>Start: </b>"+task.start_date.toLocaleDateString()+"<br/><b>End: </b>"+task.end_date.toLocaleDateString()+"<br/><b>Duration: </b>"+task.duration+"</b> "+gantt.config.duration_unit+"<br/>";
                            };
                        '),
            ]
        ],
        'drag_links_permissions' => 'PROJECTSTASKS_UPDATE'
    ],
];

if (Yii::$app->user->can('PROJECTSACTIVITIES_CREATE', ['model' => $project])) {
    $dataProviderViewWidgetConf['createNewBtnParams'] = [
        'createNewBtnLabel' => Module::tHtml('amosproject_management', 'Add new Activity'),
        'urlCreateNew' => ['/project_management/projects-activities/create', 'pid' => $project->id],
        'model' => new \lispa\amos\projectmanagement\models\ProjectsActivities()
    ];
}

?>
<?= DataProviderView::widget($dataProviderViewWidgetConf); ?>
<?php
$this->endBlock();

$itemsTab[] = [
    'label' => Module::t('amosproject_management', '#tab_activities'),
    'content' => $this->blocks['activities'],
    'options' => ['id' => 'activities'],
];
?>

<?php $this->beginBlock('costs'); ?>
<?= $this->render('../projects-progress-costs/grid',
    ['project' => $project, 'dataProvider' => $dataProviderCosts, 'currentView' => $currentViewCosts]) ?>
<?php
$this->endBlock();

$itemsTab[] = [
    'label' => Module::t('amosproject_management', '#tab_costs'),
    'content' => $this->blocks['costs'],
    'options' => ['id' => 'costs'],
];

?>

<?php $this->beginBlock('statements'); ?>
<?= $this->render('../projects-progress-statements/grid',
    ['project' => $project, 'dataProvider' => $dataProviderCosts, 'currentView' => $currentViewCosts]) ?>
<?php
$this->endBlock();

$itemsTab[] = [
    'label' => Module::t('amosproject_management', '#tab_statements'),
    'content' => $this->blocks['statements'],
    'options' => ['id' => 'statements'],
];

?>

<?php $this->beginBlock('detection-periods'); ?>

<?= $this->render('../projects-progress-detection-period/grid', [
    'project' => $project,
    'dataProvider' => $dataProviderPeriods,
    'currentView' => $currentViewPeriods,
    'availableViews' => $availableViewsPeriods
]) ?>

<?php
$this->endBlock();
$itemsTab[] = [
    'label' => Module::t('amosproject_management', '#tab_periods'),
    'content' => $this->blocks['detection-periods'],
    'options' => ['id' => 'detection-periods'],
];
?>

<?php $this->beginBlock('tab-modify-request'); ?>
<?php
echo $this->render('_tab_modify_request', [
    'modifyRequestDataProvider' => $modifyRequestDataProvider,
    'currentView' => $modifyRequestCurrentView,
    'availableViews' => $modifyRequestAvailableViews,
    'model' => $project
]);
?>
<?php $this->endBlock(); ?>
<?php
$itemsTab[] = [
    'label' => Module::t('amosproject_management', '#tab_modify_request'),
    'content' => $this->blocks['tab-modify-request'],
    'options' => ['id' => 'tab-modify-request'],
];
?>
<div class="col-xs-12 nop">
    <?= \lispa\amos\core\forms\Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]);
    ?>
</div>
