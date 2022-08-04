<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use open20\amos\core\views\DataProviderView;
use open20\amos\faq\AmosFaq;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var open20\amos\faq\models\FaqCategoriesSearch $searchModel
 */
$this->title = AmosFaq::t('amosfaq', 'Categorie');
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/faq']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-categories-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>


    <?php
    Pjax::begin();
    echo DataProviderView::widget(
        [
            'dataProvider' => $dataProvider,
            'currentView' => $currentView,
            'gridView' => [
                'columns' => [
                    //['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'titolo',
                    'descrizione:ntext',
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute'=>'deleted_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'created_by', 
//            'updated_by', 
//            'deleted_by', 
//            'version', 
                    [
                        'class' => 'open20\amos\core\views\grid\ActionColumn',
                    ],
                ],
            ]
        ]);
    Pjax::end();
    ?>

</div>
