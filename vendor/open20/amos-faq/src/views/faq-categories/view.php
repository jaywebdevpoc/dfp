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

use open20\amos\faq\AmosFaq;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var open20\amos\faq\models\FaqCategories $model
 */

$this->title = $model->titolo;
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/src/src']];
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Categorie'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-categories-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'titolo',
            'descrizione:ntext',
            /*           [
                           'attribute'=>'created_at',
                           'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                           'type'=>DetailView::INPUT_WIDGET,
                           'widgetOptions'=> [
                               'class'=>DateControl::classname(),
                               'type'=>DateControl::FORMAT_DATETIME
                           ]
                       ],
                       [
                           'attribute'=>'updated_at',
                           'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                           'type'=>DetailView::INPUT_WIDGET,
                           'widgetOptions'=> [
                               'class'=>DateControl::classname(),
                               'type'=>DateControl::FORMAT_DATETIME
                           ]
                       ],
                       [
                           'attribute'=>'deleted_at',
                           'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                           'type'=>DetailView::INPUT_WIDGET,
                           'widgetOptions'=> [
                               'class'=>DateControl::classname(),
                               'type'=>DateControl::FORMAT_DATETIME
                           ]
                       ],
                       'created_by',
                       'updated_by',
                       'deleted_by',
                       'version',*/
        ],
    ]) ?>

</div>
