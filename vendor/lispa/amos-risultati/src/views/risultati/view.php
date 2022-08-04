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

use lispa\amos\risultati\AmosRisultati;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\Risultati $model
 */

$this->title = strip_tags($model->titolo_dellinnovazione);
$this->params['breadcrumbs'][] = ['label' => AmosRisultati::t('amosrisultati', 'Risultati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="risultati-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'stato',
            'titolo_dellinnovazione',
            'sommario:html',

            'e_una_innovazione_prevalenteme' => [
                'attribute' => 'e_una_innovazione_prevalenteme',
                'value' => $model->getInnovazionePrevalentementeDi()->one()->nome
            ],

            'tecnologieRisultati' => [
                'attribute' => 'tecnologieRisultati',
                'format' => 'html',
                'label' => AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r'),
                'value' => $model->getAttrTecnologieRisultatiMm(),
            ],
            'coerenza_ads_tag',

            'stadioSviluppoRisultati' => [
                'attribute' => 'stadioSviluppoRisultati',
                'format' => 'html',
                'label' => AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione'),
                'value' => $model->getAttrStadioSviluppoRisultatiMm(),
            ],
            'referente',
            'sito_web_per_approfondimento_p',
            'cosa_ce_oggi_che_prima_non_cer:html',
            'e_importante_sapere_anche_ques:html',
            'qual_e_attualmente_il_mercato_:html',
            'ce_un_mercato_geografico_di_ri:html',
            'in_che_modo_il_lavoro_in_partn:html',

            'protezioneInnovazioneRisultati' => [
                'attribute' => 'protezioneInnovazioneRisultati',
                'format' => 'html',
                'label' => AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers'),
                'value' => $model->getAttrProtezioneInnovazioneRisultatiMm(),
            ],
            'qual_e_laziendaorganismo_di_ri',

            'bisognoPerSviluppoRisultati' => [
                'attribute' => 'bisognoPerSviluppoRisultati',
                'format' => 'html',
                'label' => AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini'),
                'value' => $model->getAttrBisognoPerSviluppoRisultatiMm(),
            ],
        ],
    ]) ?>

</div>

<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?= Html::a(AmosRisultati::t('amosrisultati', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>
</div>
