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
 * @var $idAccesso
 */

?>
<div class="sondaggi-compilazione">
    <?= $this->render('/q' . $id . '/Pagina_' . $idPagina, [
        'model' => $model,
        'idSessione' => $idSessione,
        'idPagina' => $idPagina,
        'utente' => $utente,
        'idAccesso' => $idAccesso
    ]) ?>
</div>
