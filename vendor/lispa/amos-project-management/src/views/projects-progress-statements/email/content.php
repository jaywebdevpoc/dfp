<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\projectmanagement\views\projects\email
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/** @var \lispa\amos\projectmanagement\models\ProjectsProgressStatements $model */
/** @var string $confirmedUser */
/** @var string $text */

$task = $model->projectsTask;
$link_dichiarazione = \Yii::$app->urlManager->createAbsoluteUrl($model->getFullViewUrl());

?>
<div style="border:1px solid #cccccc;padding:10px;margin-bottom: 10px;background-color: #ffffff;margin-top:20px">
    <div style="color:#000000;">
        <h2 style="font-size:2em;line-height: 1;margin:0;padding:10px 0;">
            <?= Html::a($task->name, $link_dichiarazione, ['style' => 'color: green;']) ?>
        </h2>
    </div>
    <div style="box-sizing:border-box;font-size:13px;font-weight:normal;">
        <?= Module::t('amosproject_management', $text, [
            'activityTitle' => $task->name,
            'creatorNameSurname' => $confirmedUser,
            'link_dichiarazione' => $link_dichiarazione
        ]); ?>
    </div>
</div>
