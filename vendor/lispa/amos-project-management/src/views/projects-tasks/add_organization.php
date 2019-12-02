<?php

use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\projectmanagement\Module;

/**
 * @var \lispa\amos\projectmanagement\models\Projects $model
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
    'url' => ['update', 'id' => $model->id, '#' => 'tab-organizations']
];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'Invite Organizations');

$organizationModelClass = Module::getModuleOrganization()->getOrganizationModelClass();

?>
<?= M2MWidget::widget([
    'model' => $model,
    'modelId' => $model->id,
    'modelData' => $model->getJoinedOrganizations(),
    'modelDataArrFromTo' => [
        'from' => 'id',
        'to' => 'id'
    ],
    'modelTargetSearch' => [
        'class' => $organizationModelClass::className(),
        'query' => $model->projectsActivities->projects->getJoinedOrganizations()
            ->andFilterWhere([
                'not in',
                'id',
                $model->getProjectsTasksJoinedOrganizationsMms()->select('organization_id')
            ]),//$query,
    ],

    'targetUrlController' => 'projects-tasks',
    'moduleClassName' => Module::className(),
    'postName' => 'ProjectsTask',
    'postKey' => 'projects-tasks',
    'targetColumnsToView' => [
        'name' => [
            'attribute' => 'name',
            'label' => Module::t('amosproject_management', 'Name'),
            'headerOptions' => [
                'id' => Module::t('amosproject_management', 'Name'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosproject_management', 'Name'),
            ]
        ],
        'indirizzo',
//        'numero_civico',
//        'cap'
    ],
]);
?>
