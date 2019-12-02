<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\expressions-of-interest
 * @category   CategoryName
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\partnershipprofiles\Module;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var lispa\amos\partnershipprofiles\models\search\ExpressionsOfInterestSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="expressions-of-interest-search element-to-toggle" data-toggle-element="form-search">
    
    <?php
    $form = ActiveForm::begin([
        'action' => Yii::$app->controller->action->id,
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>

    <div class="col-xs-12">
        <h2 class="title">
            <?= Module::tHtml('amospartnershipprofiles', 'Search by'); ?>:
        </h2>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'partnership_offered')->textInput(['placeholder' => Module::t('amospartnershipprofiles', 'Search by partnership offered')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'additional_information')->textInput(['placeholder' => Module::t('amospartnershipprofiles', 'Search by additional information')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'clarifications')->textInput(['placeholder' => Module::t('amospartnershipprofiles', 'Search by clarifications')]) ?>
    </div>

    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton(Module::tHtml('amospartnershipprofiles', 'Reset'), ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(Module::tHtml('amospartnershipprofiles', 'Search'), ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <!--a><p class="text-center">Advanced search<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>
</div>
