<?php

use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \lispa\amos\projectmanagement\models\ProjectsTasks $task
 */

$this->title = Module::t('amosproject_management', '#history_progress_statemets') . ': ' . $task->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $task->project,
]); ?>

<div class="projects-progress-statements-index">
    <?php
    if ($dataProvider->totalCount <= 0):
        echo Module::t('amosproject_management', 'There are no previous statements for the progress of this activity');
    else:
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'updated_at',
                        'format' => [
                            'datetime',
                            (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'
                        ]
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Progress Status'),
                        'value' => function ($model) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $model */
                            try {
                                return $model->projectsProgressStatementsType->nameTranslate;
                            } catch (Exception $e) {
                                return '';
                            }
                        }
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Responsible'),
                        'value' => function ($model) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $model */
                            try {
                                return $model->userResponsible->userProfile->getNomeCognome();
                            } catch (Exception $e) {
                                return '';
                            }
                        }
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Leader Organization'),
                        'value' => function ($model) {
                            $orgModule = Module::getModuleOrganization();
                            $orgClass = $orgModule->getOrganizationModelClass();
                            /** @var \lispa\amos\core\interfaces\OrganizationsModelInterface $org */
                            $org = $model->organizationResponsible;
                            if (empty($org)) return '';
                            return $org->nameField;
                        }
                    ],
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage());
        }
    endif;
    ?>
    <?= \lispa\amos\core\forms\CloseButtonWidget::widget(['urlClose' => \yii\helpers\Url::previous() . '#statements']); ?>

</div>
