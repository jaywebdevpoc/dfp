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

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\StadioSviluppoRisultati $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?= $this->render('_form', [
    'model' => $model,
    'fid' => (NULL !== (filter_input(INPUT_GET, 'fid'))) ? filter_input(INPUT_GET, 'fid') : '',
    'dataField' => (NULL !== (filter_input(INPUT_GET, 'dataField'))) ? filter_input(INPUT_GET, 'dataField') : '',
    'dataEntity' => (NULL !== (filter_input(INPUT_GET, 'dataEntity'))) ? filter_input(INPUT_GET, 'dataEntity') : '',
    'class' => 'dynamicCreation'
]) ?>