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
 * @var \lispa\amos\risultati\models\BisognoPerSviluppoRisultati $model
 */

$this->title = AmosRisultati::t('amosrisultati', 'Crea');
$this->params['breadcrumbs'][] = ['label' => AmosRisultati::t('amosrisultati', 'Bisogno Per Sviluppo Risultati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bisogno-per-sviluppo-risultati-create">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => NULL,
        'dataField' => NULL,
        'dataEntity' => NULL,
    ]) ?>
</div>
