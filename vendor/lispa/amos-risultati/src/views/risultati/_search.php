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
 * @var \lispa\amos\risultati\models\search\BisognoPerSviluppoRisultatiSearch $model
 * @var yii\widgets\ActiveForm $form
 */

?>
<div class="risultati-search element-to-toggle" data-toggle-element="form-search">

    <?php $form = ActiveForm::begin([
        'action' => (isset($originAction) ? [$originAction] : ['index']),
        'method' => 'get',
        'options' => [
            'class' => 'default-form'
        ]
    ]);
    ?>

    <!-- stato -->
    <div class="col-md-4">
        <?= $form->field($model, 'stato')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per stato')]) ?>
    </div>

    <!-- titolo_dellinnovazione -->
    <div class="col-md-4">
        <?= $form->field($model, 'titolo_dellinnovazione')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per titolo dellinnovazione')]) ?>
    </div>

    <!-- sommario -->
    <div class="col-md-4">
        <?= $form->field($model, 'sommario')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per sommario')]) ?>
    </div>

    <!-- e_una_innovazione_prevalenteme -->
    <div class="col-md-4">
        <?= $form->field($model, 'e_una_innovazione_prevalenteme')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per e una innovazione prevalenteme')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'attrTecnologieRisultatiMm')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per le tecnologie utilizzate per raggiungere il r')])->label(AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r')); ?>
    </div>
    <!-- coerenza_ads_tag -->
    <div class="col-md-4">
        <?= $form->field($model, 'coerenza_ads_tag')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per coerenza ads tag')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'attrStadioSviluppoRisultatiMm')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per stadio attuale di sviluppo dell’innovazione')])->label(AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione')); ?>
    </div>
    <!-- referente -->
    <div class="col-md-4">
        <?= $form->field($model, 'referente')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per referente')]) ?>
    </div>

    <!-- sito_web_per_approfondimento_p -->
    <div class="col-md-4">
        <?= $form->field($model, 'sito_web_per_approfondimento_p')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per sito web per approfondimento p')]) ?>
    </div>

    <!-- cosa_ce_oggi_che_prima_non_cer -->
    <div class="col-md-4">
        <?= $form->field($model, 'cosa_ce_oggi_che_prima_non_cer')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per cosa ce oggi che prima non cer')]) ?>
    </div>

    <!-- e_importante_sapere_anche_ques -->
    <div class="col-md-4">
        <?= $form->field($model, 'e_importante_sapere_anche_ques')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per e importante sapere anche ques')]) ?>
    </div>

    <!-- qual_e_attualmente_il_mercato_ -->
    <div class="col-md-4">
        <?= $form->field($model, 'qual_e_attualmente_il_mercato_')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per qual e attualmente il mercato')]) ?>
    </div>

    <!-- ce_un_mercato_geografico_di_ri -->
    <div class="col-md-4">
        <?= $form->field($model, 'ce_un_mercato_geografico_di_ri')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per ce un mercato geografico di ri')]) ?>
    </div>

    <!-- in_che_modo_il_lavoro_in_partn -->
    <div class="col-md-4">
        <?= $form->field($model, 'in_che_modo_il_lavoro_in_partn')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per in che modo il lavoro in partn')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'attrProtezioneInnovazioneRisultatiMm')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per la componente innovativa è protetta attravers')])->label(AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers')); ?>
    </div>
    <!-- qual_e_laziendaorganismo_di_ri -->
    <div class="col-md-4">
        <?= $form->field($model, 'qual_e_laziendaorganismo_di_ri')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per qual e laziendaorganismo di ri')]) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'attrBisognoPerSviluppoRisultatiMm')->textInput(['placeholder' => AmosRisultati::t('amosrisultati', 'Ricerca per di cosa avrebbe bisogno l’innovazione ai fini')])->label(AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini')); ?>
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
