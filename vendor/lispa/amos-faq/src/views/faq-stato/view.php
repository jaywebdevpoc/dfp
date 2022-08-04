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

use yii\widgets\DetailView;
use lispa\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\FaqStato $model
 */
$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/src/src']];
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Stati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-stato-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'nome',
            'descrizione:ntext',
        ],
    ])
    ?>

</div>
