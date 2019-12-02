<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\projectmanagement\models\ProjectsModifyRequest;
use lispa\amos\projectmanagement\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsModifyRequest $model
 */

$this->title = Module::t('amosproject_management', '#project_modify_request');
//$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects Modify Request'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(); ?>
<?php
try {
    echo \lispa\amos\workflow\widgets\WorkflowTransitionStateDescriptorWidget::widget([
        'form' => $form,
        'model' => $model,
        'workflowId' => \lispa\amos\projectmanagement\models\Projects::PROJECTS_WORKFLOW,
        'classDivIcon' => '',
        'classDivMessage' => 'message',
        'viewWidgetOnNewRecord' => true,
    ]);
} catch (Exception $e) {
    pr($e->getMessage(), 'ERROR');
}
?>
<?php ActiveForm::end(); ?>

<?= $this->render('../projects/_info_project_area', [
    'project' => $model->projects,
]); ?>

<div class="projects-modify-request-view col-xs-12">

    <?php
    try {
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => Module::t('amosproject_management', 'Status'),
                    'attribute' => 'workflowStatusLabel',
                ],
                'description:html',
                [
                    'label' => Module::t('amosproject_management', '#created_at_request'),
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDate($model->created_at);
                    },
                ],
                [
                    'label' => Module::t('amosproject_management', '#submission_date_mr'),
                    'value' => function ($model) {
                        if (!empty($model->getFirstSendToValidate())) {
                            return Yii::$app->formatter->asDate($model->getFirstSendToValidate());
                        } else {
                            return null;
                        }
                    },
                ],
                [
                    'label' => Module::t('amosproject_management', '#applicant_user'),
                    'value' => function ($model) {
                        /** @var ProjectsModifyRequest $model */
                        return $model->createdUserProfile->getNomeCognome();
                    },
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage(), 'ERROR');
    }

    ?>

    <?php
    echo $this->render('_list_of_selected', [
        'model' => $model,
    ]);
    ?>

    <div class="btnViewContainer pull-right">
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous() . '#tab-modify-request', ['class' => 'btn btn-secondary']); ?>    </div>

</div>
