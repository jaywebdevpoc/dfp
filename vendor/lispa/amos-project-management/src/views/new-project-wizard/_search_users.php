<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\new_project_wizard\StepC $model
 * @var yii\widgets\ActiveForm $form
 */

$this->registerJs(<<<JS

    $(".reset-search-form").click(function (e){
        e.preventDefault();
        $("#userprofilesearch-nome").val("");
        $("#userprofilesearch-cognome").val("");
        $(".search-button").trigger("click");
    });

JS
);

?>

<div id="search-form-users" data-toggle-element="form-search" class="element-to-toggle">
    <div class="col-xs-12 col-sm-12 col-lg-3"><h3><?= Module::t('amosproject_management', '#NEW_PROJECT_SEARCH_USER_LABEL'); ?></h3></div>

    <div class="col-sm-6 col-lg-3">
        <?= $form->field($model, 'nome') ?>
    </div>
    <div class="col-sm-6 col-lg-3">
        <?= $form->field($model, 'cognome') ?>
    </div>
<!--    <div class="col-sm-6 col-lg-3">-->
        <?php // echo $form->field($model, 'codice_fiscale') ?>
<!--        </div>-->
<!--    <div class="col-sm-6 col-lg-3">-->
        <?php // echo $form->field($model, 'email') ?>
<!--    </div>-->

    <div class="col-xs-12 col-sm-12 col-lg-3">
        <?= Html::submitButton(Yii::t('amosgroups', Module::t('amosproject_management', '#NEW_PROJECT_SEARCH_BUTTON_LABEL')), ['class' => 'btn btn-navigation-primary search-button']) ?>
        <?= Html::resetButton(Yii::t('amosgroups', Module::t('amosproject_management', '#NEW_PROJECT_RESET_BUTTON_LABEL')), ['class' => 'btn btn-secondary reset-search-form']) ?>
    </div>

    <div class="clearfix"></div>

</div>