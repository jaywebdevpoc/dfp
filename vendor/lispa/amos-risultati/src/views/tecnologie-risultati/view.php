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
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\TecnologieRisultati $model
 */

$this->title = strip_tags($model->denominazione);
$this->params['breadcrumbs'][] = ['label' => AmosRisultati::t('amosrisultati', 'Tecnologie Risultati'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tecnologie-risultati-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'denominazione',
            'descrizione:html',
        ],
    ]) ?>
</div>

<div id="form-actions" class="bk-btnFormContainer pull-right">
    <?= Html::a(AmosRisultati::t('amosrisultati', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>
</div>
