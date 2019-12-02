<?php

use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\core\user\User;
use lispa\amos\projectmanagement\Module;

/**
 * @var \lispa\amos\projectmanagement\models\Projects $model
 */

$this->title = $model . " -  " . Module::t('amosproject_management', 'Add cost items');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = [
    'label' => strip_tags($model),
    'url' => ['update', 'id' => $model->id, '#' => 'tab-cost-items']
];
$this->params['breadcrumbs'][] = Module::t('amosproject_management', 'add cost items');

?>
<?= M2MWidget::widget([
    'model' => $model,
    'modelId' => $model->id,
    'modelData' => $model->getDefaultProjectsSpendingVoices(),
    'modelDataArrFromTo' => [
        'from' => 'id',
        'to' => 'id'
    ],
    'modelTargetSearch' => [
        'class' => \lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices::className(),
        'query' => \lispa\amos\projectmanagement\models\ProjectsSpendingVoices::find()->andFilterWhere([
            'not in',
            'id',
            $model->getDefaultProjectsSpendingVoices()->select('id')
        ]),//$query,
    ],

    'targetUrlController' => 'projects',
    'moduleClassName' => Module::className(),
    'postName' => 'Project',
    'postKey' => 'projects',
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
        ]
    ],
]);
?>