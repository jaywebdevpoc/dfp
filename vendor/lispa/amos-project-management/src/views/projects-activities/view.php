<?php

use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsActivities $model
 */

$this->title = ($model->name);
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Projects'),
    'url' => ['/project_management']
];
$this->params['breadcrumbs'][] = [
    'label' => Module::t('amosproject_management', 'Project Activities'),
    'url' => ['/project_management/projects/by-project', 'pid' => $model->projects->id]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-activities-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'name',
            'description:html',

            'referent' => [
                'attribute' => 'userResponsible',
                'label' => Module::t('amosproject_management', 'Reference User'),
            ],

//            'projects' => [
//                'attribute' => 'projects',
//                'format' => 'html',
//                'label' => \lispa\amos\projectmanagement\Module::t('amosproject_management', 'Project'),
//                'value' => $model->getAttrProjectsMm(),
//            ],

            'organization' => [
                'attribute' => 'organization',
                'format' => 'html',
                'label' => \lispa\amos\projectmanagement\Module::t('amosproject_management',
                    'Reference Organization'),
                'value' => $model->getattrOrganizationMm(),
            ],
        ],
    ]) ?>

    <?php if(\lispa\amos\projectmanagement\utility\ProjectManagementUtility::loggedUsedIsCommunityManager($model->projects->community_id)){ ?>
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
                        'class' => 'first-accordion'
                    ]
                ]); ?>
            </div>
        </div>
    <?php  } ?>

</div>

<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?= Html::a(Module::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?></div>
