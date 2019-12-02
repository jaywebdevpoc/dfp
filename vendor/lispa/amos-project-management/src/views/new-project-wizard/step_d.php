<?php
/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\new_project_wizard\StepD $model
 */

use lispa\amos\projectmanagement\Module;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use yii\base\InvalidConfigException;
$this->params['breadcrumbs'][] = ['label' => '', 'hidden' => true];
$this->title = Module::t('amosproject_management', '#NEW_PROJECT_TITLE_STEP_D');
?>

<div class="col-xs-12 nop">
    <h3 class="subtitle-wizard">
        <?= Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_STEP_D'); ?>
    </h3>
</div>
<section class="">
    <?php $form = ActiveForm::begin([
        'action' => ['', 'nav' => 'next'],
    ]); ?>

    <div class="col-xs-12 nop">
        <?= Module::t('amosproject_management', '#NEW_PROJECT_EXPLAIN_STEP_D {communityName}', ['communityName' => $model->communityName()]); ?>
    </div>

    <div class="col-xs-12">
        <?php
        echo $form->field($model, 'projectTitle')->textInput();
        ?>
    </div>

    <div class="col-xs-12 btn-wizard-footer nop">
        <div class="form-group">
            <?php
            $labelBack = Module::t('amosproject_management', '#NEW_PROJECT_BACK');
            echo Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> ' . $labelBack,
                ['wizard', 'nav' => 'prev'], ['class' => 'btn btn-primary pull-left']);
            ?>
            <?php
            try {
                $labelForward = Module::t('amosproject_management', '#NEW_PROJECT_CREATE');
                echo Html::submitButton(
                    $labelForward . ' <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                    ['class' => 'btn btn-primary button-primary pull-right']);
            } catch (InvalidConfigException $e) {
            } ?>

            <?= Html::a(Module::t('amosproject_management', '#NEW_PROJECT_EXIT'), ['exit'], ['class' => 'btn btn-secondary pull-left annulla']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</section>