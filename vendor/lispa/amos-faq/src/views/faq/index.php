<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\views\DataProviderView;
use yii\widgets\Pjax;
use lispa\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\faq\models\FaqSearch $searchModel
 */
$this->title = AmosFaq::t('amosfaq', 'Faq');
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/faq']];
$this->params['breadcrumbs'][] = AmosFaq::t('amosfaq', 'Gestione Faq'); //$this->title;
?>
<div class="faq-index">
    <?php //echo $this->render('_search', ['model' => $model]); ?>

    <?php
    Pjax::begin();
    echo DataProviderView::widget(
            [
                'dataProvider' => $dataProvider,
                'currentView' => $currentView,
//                'gridView' => [
//                    'columns' => [
//                        //       ['class' => 'yii\grid\SerialColumn'],
////                    'id',
//                        'domanda:ntext',
//                        'risposta:ntext',
//            'order',
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'deleted_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'created_by', 
//            'updated_by', 
//            'deleted_by', 
//            'version', 
                        /*            [
                          'attribute' => 'faqCategoria.titolo',
                          'label' => 'Categoria',
                          ],
                          [
                          'attribute' => 'faq_widgets_id',
                          'value' => 'faqWidgets.widget_label',
                          ],
                          [
                          'attribute' => 'faqWidgets.widget_code',
                          'value' => 'faqWidgets.widget_code',
                          ],
                          [
                          'attribute' => 'faqStato.descrizione',
                          'label' => 'Stato',
                          ],
                         */
//                        [
//                            'class' => 'lispa\amos\core\views\grid\ActionColumn',
//                        ],
//                    ],
//                ],
                'listView' => [
                    'itemView' => '_item',
                ],
    ]);
    Pjax::end();
    ?>

</div>
