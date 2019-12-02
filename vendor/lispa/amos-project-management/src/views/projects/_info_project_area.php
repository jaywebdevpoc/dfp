<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;
use \lispa\amos\core\forms\AccordionWidget;

/**
 * @var \yii\web\View $this
 * @var Projects $project
 */

$moduleL = \Yii::$app->getModule('layout');
if (!empty($moduleL)) {
    \lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);
}

// errors for the passage to status validated
$errors = $project->getErrors();
if (!empty($errors)) {
    echo "<div class=\"alert alert-danger\" role=\"alert\">";
    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>";
    foreach ($errors as $error) {
        foreach ($error as $message) {
            echo "<li>$message</li>";
        }
    }
    echo "</div>";
}
?>

<div class="col-xs-12 info-project-area nop">
    <div class="col-xs-12 nop info-header">
        <div class="info-title pull-left">
            <?= Html::tag('span', Module::tHtml('amosproject_management', 'Project')) ?>
        </div>

        <div class="info-links pull-right">
            <?php if (Yii::$app->user->can('PROJECTS_UPDATE', ['model' => $project])): ?>
                <?= Html::a(
                    Html::tag('span', '', ['class' => 'dash dash-gears']) .
                    Module::tHtml('amosproject_management', '#info-project-area-configuration'),
                    ['/project_management/projects/update', 'id' => $project->id],
                    [
                        'class' => 'project-area-link'
                    ]) ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('PROJECTS_READ', ['model' => $project])): ?>
                <?= Html::a(
                    Html::tag('span', '', ['class' => 'am am-eye']) .
                    Module::tHtml('amosproject_management', '#info-project-area-view'),
                    ['/project_management/projects/view', 'id' => $project->id],
                    [
                        'class' => 'project-area-link'
                    ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-xs-12 nop info-body">

        <!-- workflow status -->
        <div class="workflow-transition-state-descriptor-widget col-lg-12 col-xs-12">
            <div class="message"><?= Module::t('amosproject_management', $project->workflowStatusLabel) ?></div>
        </div>
        <div class="clearfix"></div>
        <!-- end -->

        <div class="col-lg-6 col-xs-12 nop">
            <!--            <div class="col-xs-2 nop info-label">-->
            <?php //= Module::t('amosproject_management', 'Title') ?><!--</div>-->
            <div class="col-xs-10 nop info-value title"><?= $project->name ?></div>
            <div class="col-xs-10 nop info-value community"><?= Module::t('amosproject_management', '#info-project-area-community') .
                ' "' .
                Html::a($project->community->name, $project->community->getFullViewUrl(), ['class' => 'community-name']) .
                '"' ?>
            </div>
        </div>

        <div class="col-lg-2 col-md-9 col-xs-12 nop">
            <div class="info-label"><?= Module::t('amosproject_management', 'Start Date') ?></div>
            <div class="info-value"><?= Yii::$app->formatter->asDate($project->start_date) ?></div>
            <div class="info-label"><?= Module::t('amosproject_management', 'Finish Date') ?></div>
            <div class="info-value"><?= Yii::$app->formatter->asDate($project->finish_date) ?></div>
        </div>

        <?php if ($project->canStartProject()) { ?>
            <div class="col-lg-2 col-lg-push-2 col-md-3 col-xs-12 nop">
                <?php
                if ($project->hasTasks()) {
                    echo Html::a(
                        Module::t('amosproject_management', 'Avvia progetto'), ['/project_management/projects/by-project', 'id' => $project->id, 'startProject' => 1],
                        [
                            'class' => 'btn btn-primary',
                            'data-confirm' => Module::t('amosproject_management', 'Sei sicuro di avviare il progetto?'),

                        ]
                    );
                } else {
                    echo Html::a(
                        Module::t('amosproject_management', 'Avvia progetto'), 'javascript:void(0)',
                        [
                            'class' => 'btn btn-primary',
                            'disabled' => true,
                            'title' => Module::t('amosproject_management', "Per avviare il progetto è necessario inserire almeno 1 Work Package ed 1 Attività")

                        ]
                    );
                }
                ?>
                <p><?= Module::t('amosproject_management', 'Gli utenti con attività assegnate potranno iniziare le lavorazioni') ?></p>
            </div>
        <?php } ?>

        <div class="col-xs-12 nop">
            <?php if (!empty($project->insights)) : ?>
                <div class="info-label"><?= Module::t('amosproject_management', 'Sintesi degli obiettivi di progetto') ?></div>
                <?php
                $headerDesc = '';
                if (strlen($project->insights) > 250) {
                    $readMore = Html::tag('span', Module::t('amosproject_management', '#info-project-area-read-more'), ['class' => 'read-more']);
                    $headerDesc .= Html::tag('p', strip_tags(substr($project->insights, 0, 250)) . '... ' . $readMore);
                    echo AccordionWidget::widget([
                        'items' => [
                            [
                                'header' => $headerDesc,
                                'content' => '...' . strip_tags(substr($project->insights, 251)),
                            ]
                        ],
                        'headerOptions' => ['tag' => 'span', 'class' => 'info-label'],
                        'clientOptions' => [
                            'collapsible' => true,
                            'active' => false,
                            'icons' => [
//                            'header' => 'ui-icon-amos am am-caret-right',
                                'header' => 'ui-icon-amos',
//                            'activeHeader' => 'ui-icon-amos am am-caret-down',
                                'activeHeader' => 'ui-icon-amos',
                            ],
                        ],
                        'options' => [
                            'class' => 'info-project-area-accordion'
                        ]
                    ]);
                } else {
                    echo Html::tag('div', $project->insights, ['class' => 'info-value']);
                }
                ?>
            <?php endif ?>
        </div>
    </div>

</div>
<?php if (Yii::$app->controller->action->id != 'by-project'): ?>
    <div class="projects-activities-index">
        <div class="col-xs-3 container-secondary-actions nop">
            <?php
            echo Html::a(Module::t('amosproject_management', 'Return to the Work Package'),
                ['/project_management/projects/by-project', 'pid' => $project->id],
                ['class' => 'btn btn-primary'])
            ?>
        </div>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
