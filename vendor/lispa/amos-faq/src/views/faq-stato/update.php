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

use lispa\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\FaqStato $model
 */

$this->title = AmosFaq::t('amosfaq', 'Aggiorna stato Faq', [
    'modelClass' => 'Faq Stato',
]);
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/src/src']];
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Stati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = AmosFaq::t('amosfaq', 'Aggiorna');
?>
<div class="faq-stato-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
