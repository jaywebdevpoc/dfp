<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\projectmanagement\models\search\ProjectsActivitiesSearch $model
 */
$project = Yii::$app->view->params['modelProject'];
$dataProvider->sort = false;

//$this->title = Module::t('amosproject_management', 'Project Activities'); //  . ' ' . $project->name;
$this->title = $project->name;
//$this->params['breadcrumbs'][] = [
//    'label' => Module::t('amosproject_management', 'Projects'),
//    'url' => ['/project_management']
//];
//$this->params['breadcrumbs'][] = ['label' => strip_tags($project)];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="projects-activities-index">
    <?php echo $this->render('_search', ['model' => $model]); ?>

    <?php
    if(!is_null($project)) {
        echo $this->render('../projects/_info_project_area', [
            'project' => $project,
        ]);
    }
    ?>

    <div class="col-xs-8 col-xs-push-4 container-secondary-actions nop">
        <?php
        if (Yii::$app->user->can(\lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule::className())) {
            echo Html::a(Module::t('amosproject_management', 'Request changes to the plan'),
                Yii::$app->view->params['urlToModifyRequestIndex'],
                ['class' => 'btn btn-primary']);
        }
        ?>

        <?php
        //        if (!is_null(Yii::$app->view->params['urlToDetectionPeriodsIndex'])):
        echo Html::a(Module::t('amosproject_management', 'Detection periods'),
            Yii::$app->view->params['urlToDetectionPeriodsIndex'],
            ['class' => 'btn btn-primary']);
        //        endif;
        ?>

        <?php
        if (Yii::$app->user->can(\lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule::className())) {
            //        if (!is_null(Yii::$app->view->params['urlToDetectionPeriodsIndex'])):
            echo Html::a(Module::t('amosproject_management', 'Statements progress'),
                Yii::$app->view->params['urlToProgressStatementIndex'],
                ['class' => 'btn btn-primary']);
            //        endif;
        }
        ?>

        <?php
        if (Yii::$app->user->can(\lispa\amos\projectmanagement\rules\ProjectsModifyRequestIndexRule::className())) {
            //        if (!is_null(Yii::$app->view->params['urlToDetectionPeriodsIndex'])):
            echo Html::a(Module::t('amosproject_management', 'Costs progress'),
                Yii::$app->view->params['urlToProgressCostsIndex'],
                ['class' => 'btn btn-primary']);
            //        endif;
        }
        ?>
    </div>
    <div class="clearfix"></div>

    <?php

    try {
        echo DataProviderView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $model,
            'currentView' => $currentView,
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
                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
                    ],
                ],
            ],
            'ganttView' => [
                'model' => Yii::$app->view->params['modelProject'],
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

        ]);
    } catch (Exception $e) {
        pr($e->getMessage(), 'ERROR');
    }

    ?>

</div>
