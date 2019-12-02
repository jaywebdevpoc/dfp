<?php

use lispa\amos\core\helpers\Html;
use yii\widgets\ActiveForm;
use lispa\amos\projectmanagement\Module;

/**
* @var yii\web\View $this
* @var lispa\amos\projectmanagement\models\search\ProjectsModifyRequestSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="projects-modify-request-search element-to-toggle" data-toggle-element="form-search">
    <div class="col-xs-12"><h2>Cerca per:</h2></div>

    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->controller->action->id,
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);

    echo Html::hiddenInput("enableSearch", "1");
    echo Html::hiddenInput("currentView", Yii::$app->request->getQueryParam('currentView'));
    ?>

    <div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'id') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'status') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'description') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'projects_id') ?></div><div class="col-sm-6 col-lg-4">    <?= $form->field($model, 'created_at') ?></div>    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton(Module::t('amosproject_management', 'Reset'), ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(Module::t('amosproject_management', 'Search'), ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
<!--a><p class="text-center">Ricerca avanzata<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>

</div>
