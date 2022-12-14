<?php
use lispa\amos\core\utilities\ViewUtility;
use lispa\amos\sondaggi\AmosSondaggi;

use kartik\detail\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\sondaggi\models\SondaggiRisposte $model
 */

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => AmosSondaggi::t('amossondaggi', 'Sondaggi Rispostes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sondaggi-risposte-view">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        //'risposta:ntext',
        'sondaggi_domande_id',
        //'pei_accessi_servizi_facilitazione_id',
        'sondaggi_risposte_sessioni_id',
        ['attribute' => 'created_at', 'format' => ['datetime', ViewUtility::formatDateTime()]],
        ['attribute' => 'updated_at', 'format' => ['datetime', ViewUtility::formatDateTime()]],
        ['attribute' => 'deleted_at', 'format' => ['datetime', ViewUtility::formatDateTime()]],
        'created_by',
        'updated_by',
        'deleted_by',
        'version',
    ],
]) ?>
</div>
