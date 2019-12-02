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

$this->params['textHelp']['filename'] = 'index_description';
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

    <?php
    echo $this->render('../projects/_tab_modify_request', [
        'model' => $model,
        'modifyRequestDataProvider' => $dataProvider,
//        'onlyView' => $onlyView,
    ]);
    ?>

</div>
