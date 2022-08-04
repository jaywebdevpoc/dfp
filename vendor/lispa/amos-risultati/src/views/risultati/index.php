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

use lispa\amos\core\views\DataProviderView;
use lispa\amos\risultati\AmosRisultati;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var \lispa\amos\risultati\models\search\RisultatiSearch $model
 * @var string $currentView
 */

$this->title = AmosRisultati::t('amosrisultati', 'Risultati');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="risultati-index">
    <?php echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a('Nuovo Risultati'        , ['create'], ['class' => 'btn btn-amministration-primary'])*/ ?>
    </p>

    <?php echo DataProviderView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $model,
        'currentView' => $currentView,
        'gridView' => [
            'columns' => [
//                'stato',
                'titolo_dellinnovazione',
//                'sommario:striptags',

                'e_una_innovazione_prevalenteme' => [
                    'attribute' => 'e_una_innovazione_prevalenteme',
                    'value' => 'innovazionePrevalentementeDi.nome'
                ],

//                'tecnologieRisultati' => [
//                    'attribute' => 'tecnologieRisultati',
//                    'format' => 'html',
//                    'label' => AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r'),
//                    'value' => function ($model) {
//                        /** @var \lispa\amos\risultati\models\Risultati $model */
//                        return strip_tags($model->getAttrTecnologieRisultatiMm(','));
//                    }
//                ],
//                'coerenza_ads_tag',

                'stadioSviluppoRisultati' => [
                    'attribute' => 'stadioSviluppoRisultati',
                    'format' => 'html',
                    'label' => AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione'),
                    'value' => function ($model) {
                        /** @var \lispa\amos\risultati\models\Risultati $model */
                        return strip_tags($model->getAttrStadioSviluppoRisultatiMm(','));
                    }
                ],
//                'referente' => [
//                    'attribute' => 'referente',
//                    'value' => 'referenteNomeCognome'
//                ],
//                'sito_web_per_approfondimento_p',
//                'cosa_ce_oggi_che_prima_non_cer:striptags',
//                'e_importante_sapere_anche_ques:striptags',
//                'qual_e_attualmente_il_mercato_:striptags',
//                'ce_un_mercato_geografico_di_ri:striptags',
//                'in_che_modo_il_lavoro_in_partn:striptags',
//
//                'protezioneInnovazioneRisultati' => [
//                    'attribute' => 'protezioneInnovazioneRisultati',
//                    'format' => 'html',
//                    'label' => AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers'),
//                    'value' => function ($model) {
//                        /** @var \lispa\amos\risultati\models\Risultati $model */
//                        return strip_tags($model->getAttrProtezioneInnovazioneRisultatiMm(','));
//                    }
//                ],
//                'qual_e_laziendaorganismo_di_ri' => [
//                    'attribute' => 'qual_e_laziendaorganismo_di_ri',
//                    'value' => 'organizzazione.denominazione'
//                ],
//
//                'bisognoPerSviluppoRisultati' => [
//                    'attribute' => 'bisognoPerSviluppoRisultati',
//                    'format' => 'html',
//                    'label' => AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini'),
//                    'value' => function ($model) {
//                        /** @var \lispa\amos\risultati\models\Risultati $model */
//                        return strip_tags($model->getAttrBisognoPerSviluppoRisultatiMm(','));
//                    }
//                ],
                [
                    'class' => 'lispa\amos\core\views\grid\ActionColumn',
                ],
            ],
        ],
        /*'listView' => [
        'itemView' => '_item'
        'masonry' => FALSE,

        // Se masonry settato a TRUE decommentare e settare i parametri seguenti 
        // nel CSS settare i seguenti parametri necessari al funzionamento tipo
        // .grid-sizer, .grid-item {width: 50&;}
        // Per i dettagli recarsi sul sito http://masonry.desandro.com                                     

        //'masonrySelector' => '.grid',
        //'masonryOptions' => [
        //    'itemSelector' => '.grid-item',
        //    'columnWidth' => '.grid-sizer',
        //    'percentPosition' => 'true',
        //    'gutter' => '20'
        //]
        ],
        'iconView' => [
        'itemView' => '_icon'
        ],
        'mapView' => [
        'itemView' => '_map',          
        'markerConfig' => [
        'lat' => 'domicilio_lat',
        'lng' => 'domicilio_lon',
        'icon' => 'iconaMarker',
        ]
        ],
        'calendarView' => [
        'itemView' => '_calendar',
        'clientOptions' => [
        //'lang'=> 'de'
        ],
        'eventConfig' => [
        //'title' => 'titoloEvento',
        //'start' => 'data_inizio',
        //'end' => 'data_fine',
        //'color' => 'coloreEvento',
        //'url' => 'urlEvento'
        ],
        'array' => false,//se ci sono più eventi legati al singolo record
        //'getEventi' => 'getEvents'//funzione da abilitare e implementare nel model per creare un array di eventi legati al record
        ]*/
    ]); ?>

</div>
