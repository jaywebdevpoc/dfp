<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\views\projects\email
 * @category   CategoryName
 */

use lispa\amos\projectmanagement\models\ProjectsProgressDetectionPeriod;
use lispa\amos\projectmanagement\Module;

/** @var ProjectsProgressDetectionPeriod $model */
/** @var string $confirmedUser */
/** @var string $text */

$title = '';
if ($model->projects_progress_detection_type_id == ProjectsProgressDetectionPeriod::STATEMENTS_TYPE) {
    $title = '#subject_statement_detection';
    $link_rilevaz = \Yii::$app->params['platform']['backendUrl']."/project_management/projects-progress-statements/index?pid=".$model->projects->id;

}
if ($model->projects_progress_detection_type_id == ProjectsProgressDetectionPeriod::COSTS_TYPE) {
    $title = '#subject_project_cost';
    $link_rilevaz = \Yii::$app->params['platform']['backendUrl']."/project_management/projects-progress-costs/index?pid=".$model->projects->id;

}
?>
<div style="border:1px solid #cccccc;padding:10px;margin-bottom: 10px;background-color: #ffffff;margin-top:20px">
    <div style="color:#000000;">
        <h2 style="font-size:2em;line-height: 1;margin:0;padding:10px 0;">
            <?= Module::t('amosproject_management', $title, ['title_project' => $model->projects->name]) ?>
        </h2>
    </div>

    <div style="box-sizing:border-box;font-size:13px;font-weight:normal;">
        <?php
        echo Module::t('amosproject_management', $text, [
            'startDate' => Yii::$app->formatter->asDate($model->start_date),
            'endDate' => Yii::$app->formatter->asDate($model->end_date),
            'link_rilevaz' => $link_rilevaz
        ]);

        ?>
    </div>
</div>
