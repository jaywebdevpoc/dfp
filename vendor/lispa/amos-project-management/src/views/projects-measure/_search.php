<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use kartik\datecontrol\DateControl;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\search\ProjectsMeasureSearch $model
 * @var yii\widgets\ActiveForm $form
 */


?>
<div class="projects-measure-search element-to-toggle" data-toggle-element="form-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>

    <!-- name -->
    <div class="col-md-4"> <?=
        $form->field($model, 'name')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per name')
        ]) ?>

    </div>

    <!-- description -->
    <div class="col-md-4"> <?=
        $form->field($model, 'description')->textInput([
            'placeholder' => Module::t('amosproject_management', 'ricerca per description')
        ]) ?>

    </div>

    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton('Search', ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <!--a><p class="text-center">Ricerca avanzata<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>
</div>
