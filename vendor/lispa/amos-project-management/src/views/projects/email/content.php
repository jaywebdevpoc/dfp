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
use \lispa\amos\projectmanagement\Module;

/** @var \lispa\amos\projectmanagement\models\Projects $model */
/** @var string $text */

?>
<div style="border:1px solid #cccccc;padding:10px;margin-bottom: 10px;background-color: #ffffff;margin-top:20px">
    <div style="color:#000000;">
        <h2 style="font-size:2em;line-height: 1;margin:0;padding:10px 0;">
            <?= Html::a($model->name, \Yii::$app->urlManager->createAbsoluteUrl($model->getFullViewUrl()), ['style' => 'color: green;']) ?>
        </h2>
    </div>

    <div style="box-sizing:border-box;font-size:13px;font-weight:normal;">
        <?php
        echo Module::t('amosproject_management', $text,[
            'projectLink' => Html::a(Module::t('amosproject_management', 'link'), \yii\helpers\Url::to('/project_management/projects/by-project?id='.$model->id,true)),
        ]) ;

        ?>
    </div>
</div>
