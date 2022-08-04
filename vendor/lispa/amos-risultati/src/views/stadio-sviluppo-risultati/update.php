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

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\StadioSviluppoRisultati $model
 */

$this->title = AmosRisultati::t('amosrisultati', 'Aggiorna');
$this->params['breadcrumbs'][] = ['label' => AmosRisultati::t('amosrisultati', 'Stadio Sviluppo Risultati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model->denominazione), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stadio-sviluppo-risultati-update">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => NULL,
        'dataField' => NULL,
        'dataEntity' => NULL,
    ]) ?>
</div>
