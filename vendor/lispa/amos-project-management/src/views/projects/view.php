<?php

use lispa\amos\core\forms\AccordionWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\Projects $model
 * @var \yii\data\ActiveDataProvider $modifyRequestDataProvider
 * @var \yii\data\ActiveDataProvider $organizationDataProvider
 */

//$moduleL = \Yii::$app->getModule('layout');
//if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
//}

$this->title = strip_tags($model);
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="projects-form col-xs-12 nop">

    <div class="col-xs-12 info-view-header">

        <div class="col-lg-2 col-xs-12 nop">
            <?php
            $url = '/img/img_default.jpg';
            if (!is_null($model->logo)) {
                $url = $model->logo->getUrl('square_large', false, true);
            }
            Yii::$app->imageUtility->methodGetImageUrl = 'getUrl';
            $roundImage = Yii::$app->imageUtility->getRoundImage($model->logo);
            $logo = Html::img($url,
                [
                    'class' => $roundImage['class'],
                    'style' => "margin-left: " . $roundImage['margin-left'] . "%; margin-top: " . $roundImage['margin-top'] . "%;",
                    'alt' => $model->getAttributeLabel('logo')
                ]);
            ?>
            <div class="container-round-img">
                <?= $logo ?>
            </div>
        </div>

        <div class="col-lg-10 col-xs-12 info-body nop">
            <div class="col-lg-12 col-xs-12 nop">
                <div class="col-xs-2 nop info-label"><?= Module::t('amosproject_management', 'Title') ?></div>
                <div class="col-xs-10 nop info-value"><?= $model->name ?></div>
            </div>
            <div class="col-lg-12 col-xs-12 nop">
                <div class="col-xs-2 nop info-label"><?= Module::t('amosproject_management', 'Summary') ?></div>
                <div class="col-xs-10 nop info-value"><?= $model->summary ?></div>
            </div>
            <div class="col-lg-12 col-xs-12 nop">
                <div class="col-xs-2 nop info-label"><?= $model->getAttributeLabel('status') ?></div>
                <div class="col-xs-10 nop info-value"><?= Module::t('amosproject_management', $model->getWorkflowStatus()->getLabel()) ?></div>
            </div>
            <?php

            if (Yii::$app->controller->action->id != 'by-project'): ?>
                <div class="col-lg-12 col-xs-12 nop">
                    <?php
                        echo Html::a(Module::t('amosproject_management', 'Return to the Work Package'),
                            ['/project_management/projects/by-project', 'pid' => $model->id],
                            ['class' => 'btn btn-navigation-primary pull-right'])
                        ?>
                </div>
            <?php endif; ?>

            <?php
            try {
                echo \lispa\amos\core\forms\ContextMenuWidget::widget([
                    'model' => $model,
                    'actionModify' => "/project_management/projects/update?id=" . $model->id,
                    'actionDelete' => "/project_management/projects/delete?id=" . $model->id,
                    'labelDeleteConfirm' => Module::t('amosproject_management', 'If you proceed with this action, the ACTIVITIES PLAN associated with the project will also be deleted. Are you sure you want to delete this item?'),
                    'mainDivClasses' => ''
                ]);
            } catch (Exception $e) {
            } ?>
        </div>

    </div>

    <div class="col-xs-12 info-view-body">
        <div class="col-lg-3 col-xs-12 nop">
            <div class="col-xs-4 nop info-label"><?= Module::t('amosproject_management', 'Start Date') ?></div>
            <div class="col-xs-8 nop info-value"><?= Yii::$app->formatter->asDate($model->start_date) ?></div>
        </div>
        <div class="col-lg-3 col-xs-12 nop">
            <div class="col-xs-4 nop info-label"><?= Module::t('amosproject_management', 'Finish Date') ?></div>
            <div class="col-xs-8 nop info-value"><?= Yii::$app->formatter->asDate($model->finish_date) ?></div>
        </div>
        <div class="col-lg-4 col-xs-12 nop">
            <div class="col-xs-6 nop info-label"><?= Module::t('amosproject_management', '#project_measure') ?></div>
            <div class="col-xs-6 nop info-value"><?= $model->getAttrProjectsMeasureMm() ?></div>
        </div>
        <div class="col-lg-2 col-xs-12 nop">
            <div class="col-xs-4 nop info-label"><?= Module::t('amosproject_management', 'Website') ?></div>
            <div class="col-xs-8 nop info-value"><?= $model->website ?></div>
        </div>
        <div class="col-lg-12 col-xs-12 nop">
            <div class="col-xs-1 nop info-label description-label"><?= Module::t('amosproject_management', 'Description') ?></div>
            <div class="col-xs-11 nop info-value"><?= $model->insights ?></div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            $roles = $this->render('_tab_roles', [
                'model' => $model,
                'onlyView' => true,
            ]);
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', 'Participants'),
                        'content' => $roles,
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
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            $organization = $this->render('_tab_organizations', [
                'organizationDataProvider' => $organizationDataProvider,
                'projectId' => $model->id
            ]);
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_view_participants'),
                        'content' => $organization,
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
            ]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            $spending = Html::ul(\yii\helpers\ArrayHelper::map($model->projectsSpendingVoices, 'id', 'name'));
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_view_spending'),
                        'content' => $spending,
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
            ]);
            ?>
        </div>
        <?php if(\lispa\amos\projectmanagement\utility\ProjectManagementUtility::loggedUsedIsCommunityManager($model->community_id)){ ?>
                <div class="col-xs-12 m-t-0">
                    <?php $costs = '';
                    $costTotForRow = [];
                    ?>
                    <?php if (!$model->isNewRecord): ?>
                        <?php
                        $costs = '<table class="table"><thead class="thead-default"><tr><th>' .
                            Module::t('amosproject_management', '#project_update_spending') .
                            '</th>';

                        $workPackageOrganizations = $model->projectOrganizations;

                        foreach ($workPackageOrganizations as $organization) {
                            $costs .= '<th>' . $organization->name . '</th>';
                        }
                        $costs .= '<th>'.Module::t('amosproject_management', 'Totale per voce di spesa').'</th>';
                        $costs .= '</tr>
                </thead>
                <tbody>';

                        $totalByOrg = [];

                        foreach ($model->projectsSpendingVoices as $costItem) {
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
                                    '€ ' .  (!empty($costTotForRow[$costItem->id]) ? $costTotForRow[$costItem->id] : 0) , [
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
                        <?php $costs = Module::t('amosproject_management', 'Save the activity to enable this section'); ?>
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
                        ]
                    ]); ?>
                </div>
        <?php  } ?>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?php
            $modifyRequest = $this->render('_tab_modify_request', [
                'onlyView' => true,
                'modifyRequestDataProvider' => $modifyRequestDataProvider,
            ]);
            ?>
            <?= AccordionWidget::widget([
                'items' => [
                    [
                        'header' => Module::t('amosproject_management', '#project_view_modify_request'),
                        'content' => $modifyRequest,
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
            ]);
            ?>
        </div>
    </div>




    <?= CreatedUpdatedWidget::widget(['model' => $model, 'containerOptions' => ['class' => 'm-t-20']]) ?>
</div>


<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?php //\yii\helpers\Html::a(Module::t('amosproject_management', 'Activity Plan'),
//        ['/project_management/projects/by-project', 'id' => $model->id],
//        ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Module::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?></div>
