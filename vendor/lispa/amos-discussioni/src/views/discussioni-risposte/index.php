<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\discussioni
 * @category   CategoryName
 */

use lispa\amos\core\views\AmosGridView;
use lispa\amos\core\utilities\ViewUtility;
use lispa\amos\discussioni\AmosDiscussioni;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\discussioni\models\search\DiscussioniRisposteSearch $searchModel
 */

$this->title = AmosDiscussioni::t('amosdiscussioni', 'Discussioni Risposte');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discussioni-risposte-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= AmosGridView::widget([
        'dataProvider' => $dataProvider,
        'showPageSummary' => true,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'testo:ntext',
            'discussioni_topic_id',
            ['attribute' => 'created_at', 'format' => ['datetime', ViewUtility::formatDateTime()]],
            ['attribute' => 'updated_at', 'format' => ['datetime', ViewUtility::formatDateTime()]],

            ['class' => 'lispa\amos\core\views\grid\ActionColumn',],
        ],
    ]); ?>

</div>
