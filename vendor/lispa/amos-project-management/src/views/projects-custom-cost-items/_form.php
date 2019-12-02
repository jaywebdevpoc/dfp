<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\projectmanagement\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="projects-states-form col-xs-12 nop">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'projects-states_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
            'class' => ((isset($class)) ? $class : '')
        ]
    ]);
    ?>

    <div class="row">
        <div class="col-xs-12">
            <h2 class="subtitle-form"><?= Module::t('amosproject_management', '#project_custom_cost_general_settings') ?></h2>
        </div>
        <div class="col-lg-6 col-sm-6"><!-- name string -->
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
    </div>
    <div class="clearfix"></div>

    <?= CreatedUpdatedWidget::widget(['model' => $model,'containerOptions' => ['class' => 'm-t-20']]) ?>
    <?= CloseSaveButtonWidget::widget([
        'model' => $model,
        'urlClose' => '/project_management/projects/update?id=' . $model->projects_id . '#tab-cost-items'
    ]); ?>
    <?php ActiveForm::end(); ?>
</div>
