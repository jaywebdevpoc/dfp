<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\sondaggi\views\sondaggi
 * @category   CategoryName
 */

use lispa\amos\sondaggi\AmosSondaggi;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\sondaggi\models\Sondaggi $model
 */

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => AmosSondaggi::t('amossondaggi', 'Sondaggi'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sondaggi-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'titolo:ntext',
            'descrizione:ntext',
            'status' => [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \lispa\amos\sondaggi\models\search\SondaggiSearch $model */
                    return $model->hasWorkflowStatus() ? $model->getWorkflowStatus()->getLabel() : '--';
                }
            ],
            //'filemanager_mediafile_id',
            /* [
              'attribute'=>'created_at',
              'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
              ],
              [
              'attribute'=>'updated_at',
              'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
              ],
              [
              'attribute'=>'deleted_at',
              'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
              ],
              'created_by',
              'updated_by',
              'deleted_by',
              'version', */
        ],
    ]) ?>
</div>
