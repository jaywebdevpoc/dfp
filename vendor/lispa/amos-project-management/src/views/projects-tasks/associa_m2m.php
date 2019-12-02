<?php

use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsTasks $model
 * @var \lispa\amos\projectmanagement\models\base\ProjectsActivities $activity
 */

$activity = $model->projectsActivities;

$this->title = $model;
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = ['label' => strip_tags($activity->projects)];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects-activities/by-project', 'pid' => $activity->projects->id]
];
$this->params['breadcrumbs'][] = [
    'label' => strip_tags($model),
    'url' => ['update', 'id' => $model->id, '#' => 'tab-dependencies']
];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Task Requirement');

?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->project,
]); ?>

<?= M2MWidget::widget([
    'model' => $model,
    'modelId' => $model->id,
    'modelData' => $model->getRequiredTasks(),
    'modelDataArrFromTo' => [
        'from' => 'id',
        'to' => 'id'
    ],
    'modelTargetSearch' => [
        'class' => ProjectsTasks::className(),
        'query' => ProjectsTasks::find()
            ->andFilterWhere(['not in', 'projects_tasks.id', $model->getRequiredTasks()->select('projects_tasks.id')])
            ->andFilterWhere(['not in', 'projects_tasks.id', $model->id])
            ->andFilterWhere([
                'in',
                'projects_tasks.id',
                $model->projectsActivities->projects->getProjectTasks()->select('projects_tasks.id')
            ]),//$query,
    ],

    'targetUrlController' => 'projects-tasks',
    'moduleClassName' => Module::className(),
    'postName' => 'Task',
    'postKey' => 'tasks',
    'targetColumnsToView' => [
        'activity_name' => [
            'attribute' => 'projectsActivities.name',
            'label' => Module::t('amosproject_management', 'WP Name'),
            'headerOptions' => [
                'id' => Module::t('amosproject_management', 'WP Name'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosproject_management', 'WP Name'),
            ]
        ],
        'name' => [
            'attribute' => 'name',
            'label' => Module::t('amosproject_management', 'Activity Name'),
            'headerOptions' => [
                'id' => Module::t('amosproject_management', 'Activity Name'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosproject_management', 'Activity Name'),
            ]
        ],
        'start_date' => [
            'attribute' => 'start_date',
            'format' => [
                'datetime',
                (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'
            ],
            'label' => Module::t('amosproject_management', 'Start Date'),
            'headerOptions' => [
                'id' => Module::t('amosproject_management', 'Start Date'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosproject_management', 'Start Date'),
            ]
        ],
        'endDate' => [
            'attribute' => 'endDate',
            'format' => [
                'datetime',
                (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'
            ],
            'label' => Module::t('amosproject_management', 'End Date'),
            'headerOptions' => [
                'id' => Module::t('amosproject_management', 'End Date'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosproject_management', 'End Date'),
            ]
        ]
    ],
]);
?>