<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\Module;
use yii\bootstrap\Modal;

/**
 * @var yii\web\View $this
 * @var lispa\amos\projectmanagement\models\ProjectsStates $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php Modal::begin(['id' => 'new-cost-item-modal']) ?>

        <?php
        $form2 = ActiveForm::begin([
            'id' => 'sp-form',
            'action' => '/project_management/projects-custom-cost-items/create-ajax?projectId='.$projectId,
            'options' => ['data-url' => '/project_management/projects-custom-cost-items/create?projects_id='.$projectId],
        ]);
//        $costItem = new \lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices();
//        $costItem->projects_id = $projectId;
        ?>
        <?= $form2->field($model, 'projects_id')->hiddenInput(['value' => $projectId])->label(false) ?>
        <div class="row">
            <div class="col-xs-12"><!-- name string -->
                <?= $form2->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
        </div>
        <div class="clearfix"></div>

        <div class='bk-btnFormContainer'>
            <?= Html::submitButton(Module::t('amoscore', 'Salva'), [
                'class' => 'btn btn-primary',
                'id' => 'save-cost-item',
            ]) ?>
            <?= Html::a(Module::t('amoscore', 'Annulla'), null,
                ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) ?>
        </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end() ?>

