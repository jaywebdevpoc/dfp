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

/**
 * @var yii\web\View $this
 * @var open20\amos\faq\models\Faq $model
 */

$this->title = AmosFaq::t('amosfaq', 'Aggiorna {modelClass}', [
        'modelClass' => 'Faq',
    ]);
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->domanda, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = AmosFaq::t('amosfaq', 'Aggiorna');
?>
<div class="faq-update">

    <?= $this->render('_form', [
        'model' => $model,
        //'listaWidget' => $listaWidget,
    ]) ?>

</div>
