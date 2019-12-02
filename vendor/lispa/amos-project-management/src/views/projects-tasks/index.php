<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\projectmanagement\models\search\ProjectsTasksSearch $model
 */

$this->title = Module::t('amosproject_management', 'Project Tasks');
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['/project_management']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-tasks-index">
    <?php echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a('Nuovo Projects Tasks'        , ['create'], ['class' => 'btn btn-administration-primary'])*/ ?>
    </p>

    <?php echo DataProviderView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $model,
        'currentView' => $currentView,
        'gridView' => [
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'description:striptags',

                'projectsActivities' => [
                    'attribute' => 'projectsActivities',
                    'format' => 'html',
                    'label' => Module::t('amosproject_management', 'Activity'),
                    'value' => function ($model) {
                        return strip_tags($model->getAttrProjectsActivitiesMm(','));
                    }
                ],

                'organization' => [
                    'attribute' => 'organization',
                    'format' => 'html',
                    'label' => Module::t('amosproject_management', 'Reference Organization'),
                    'value' => function ($model) {
                        return strip_tags($model->getattrOrganizationMm(','));
                    }
                ],

                'projectsTaskStatuses' => [
                    'attribute' => 'projectsTaskStatuses',
                    'format' => 'html',
                    'label' => Module::t('amosproject_management', 'Status'),
                    'value' => function ($model) {
                        return strip_tags($model->getAttrProjectsTaskStatusesMm(','));
                    }
                ],
                'start_date:date',
                'endDate:date',
                'duration',
//
//                'tasks' => [
//                    'attribute' => 'tasks',
//                    'format' => 'html',
//                    'label' => 'Dependencies',
//                    'value' => function ($model) {
//                        return strip_tags($model->getAttrTasksMm(','));
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
