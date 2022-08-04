<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\helpers\Html;
use lispa\amos\risultati\AmosRisultati;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\search\StadioSviluppoRisultatiSearch $model
 * @var yii\widgets\ActiveForm $form
 */

?>
<div class="stadio-sviluppo-risultati-search element-to-toggle" data-toggle-element="form-search">

    <?php $form = ActiveForm::begin([
        'action' => (isset($originAction) ? [$originAction] : ['index']),
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>

    <!-- denominazione -->
    <div class="col-md-4">
        <?= $form->field($model, 'denominazione')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per denominazione')]) ?>
    </div>

    <!-- descrizione -->
    <div class="col-md-4">
        <?= $form->field($model, 'descrizione')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per descrizione')]) ?>
    </div>

    <div class="col-xs-12">
        <div class="pull-right">
            <?= Html::resetButton(AmosRisultati::t('amosrisultati', 'Resetta'), ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(AmosRisultati::t('amosrisultati', 'Cerca'), ['class' => 'btn btn-navigation-primary']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <!--a><p class="text-center">Ricerca avanzata<br>
            < ?=AmosIcons::show('caret-down-circle');?>
        </p></a-->
    <?php ActiveForm::end(); ?>
</div>
