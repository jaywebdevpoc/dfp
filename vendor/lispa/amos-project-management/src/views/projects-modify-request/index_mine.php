<?php

use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\projectmanagement\models\search\ProjectsModifyRequestSearch $model
 */

$this->title = Module::t('amosproject_management', 'Projects Modify Request');
$this->params['breadcrumbs'][] = $this->title;

$this->params['textHelp']['filename'] = 'index_mine_description';
?>

<?php
try {
    $project = \lispa\amos\projectmanagement\models\Projects::findOne(Yii::$app->request->get('pid'));
    echo $this->render('../projects/_info_project_area', [
        'project' => $project,
    ]);
} catch (Exception $e) {
    pr($e->getMessage());
}
?>

<div class="projects-modify-request-index">
    <?php // echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a(Module::t('amosproject_management', 'Nuovo {modelClass}', [
    'modelClass' => 'Projects Modify Request',
])        , ['create'], ['class' => 'btn btn-administration-primary'])*/ ?>
    </p>

    <?php try {
        echo DataProviderView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $model,
            'currentView' => $currentView,
            'gridView' => [
                'columns' => [
                    'status' => [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            /** @var \lispa\amos\projectmanagement\models\ProjectsModifyRequest $model */
                            return $model->hasWorkflowStatus() ? Module::t('amosproject_management', $model->getWorkflowStatus()->getLabel()) : '--';
                        }
                    ],

//                    mettere per prima "Inviato la prima volta alla validazione"
//cancellare "created at"
//cambiare "nome e cognome" con "richiesta inviata da"
//inserire "organizzazione"
//inserire "wp/ attività"


//                    [
//                        'attribute' => 'created_at',
//                        'format' => ['datetime',
//                            (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']
//                    ],
                    [
                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
                    ],
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage().' '. $e->getFile().' '. $e->getLine(), 'ERROR');
    } ?>

</div>
