<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\views\pubblicazione
 * @category   CategoryName
 */

/**
 * @var $model
 * @var $idSessione
 * @var $idPagina
 * @var $utente
 */

$arrayModelRisposte = [];
foreach ((Array)$risposteWithFiles as $rispostaWithFile){
    $nomeVariabileDomanda = 'file_'.$rispostaWithFile->sondaggi_domande_id;
    $arrayModelRisposte [$nomeVariabileDomanda]= $rispostaWithFile;
}
?>

<div class="sondaggi-compilazione">
    <?= $this->render('@backend/' . $this->context->module->id . '/pubblicazione/views/q' . $id . '/Pagina_' . $idPagina, \yii\helpers\ArrayHelper::merge([
        'model' => $model,
        'idSessione' => $idSessione,
        'idPagina' => $idPagina,
        'utente' => $utente,
    ], $arrayModelRisposte)) ?>
</div>
