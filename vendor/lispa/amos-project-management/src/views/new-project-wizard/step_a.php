<?php
/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\new_project_wizard\StepA $model
 */

use lispa\amos\projectmanagement\Module;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use yii\base\InvalidConfigException;

\lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => '', 'hidden' => true];
$this->title = Module::t('amosproject_management', '#NEW_PROJECT_TITLE_STEP_A');


$js = <<< JS

//if back to step one selection field will be empty
$('#select-community').val('');

// if($('#select-community').val() == ''){
  $('#button-arrow').prop("disabled",true);
  $('#button-create').prop("disabled",false);  
// } else {
//     $('#button-arrow').attr("disabled",false);
//     $('#button-create').prop("disabled",true);
// }

$('#select-community').on('change', function (e) {
    var data = $(this).select2('data');
    console.log(data[0].id);
    if ((data.length > 0) && data[0].id != "") {
        $('#button-arrow').attr("disabled",false);
        $('#button-create').prop("disabled",true);
    } else {
         $('#button-arrow').attr("disabled",true);
         $('#button-create').prop("disabled",false);
    }
});
JS;
$this->registerJs($js, \yii\web\View::POS_READY);

?>
<section class="step-a">
    <?php $form = ActiveForm::begin([
        'action' => ['', 'nav' => 'next'],
    ]); ?>
    <div class="col-xs-12 nop wizard-description">
        <?= Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_STEP_A'); ?>


    </div>
    <div class="col-xs-12 wizard-options nop">
        <div class="col-md-4 col-md-push-1 wizard-option-1">
            <?= Module::tHtml('amosproject_management', '#NEW_PROJECT_DESCRIPTION_NO_COMMUNITY'); ?>
            <div class="col-xs-12 nop btn-container">
                <?php
                $model->forceEvalutaModel = true;
                echo $form->field($model, 'forceEvalutaModel')->hiddenInput()->label(false);

                try {
                    echo Html::submitButton(
                        Module::t('amosproject_management', 'Create') . Html::tag('span', '', ['class' => 'am am-chevron-right']),
                        [
                            'class' => 'btn btn-navigation-primary',
                            'id' => 'button-create'
                        ]
                    );
                } catch (InvalidConfigException $e) {
                }
                ?>
            </div>
        </div>

        <?php

        if (count($model->getCommunityPartecipans()) > 1):
        ?>
        <div class="col-md-2 col-md-push-1 wizard-or">
            <?= Html::tag('p', Module::t('amosproject_management', '#NEW_PROJECT_OR')) ?>
        </div>
        <div class="col-md-4 col-md-push-1 wizard-option-2">
            <?= Html::tag('p', Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_COMMUNITY')) ?>
            <div class="col-xs-12 form-and-button">
                <?php

                echo $form->field($model, 'select')->widget(\kartik\select2\Select2::className(), [
                    'data' => $model->getCommunityPartecipans(),
                    'options' => [
                        'placeholder' => Module::t('amosproject_management', 'Select...'),
                        'id' => 'select-community',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?php
                try {
                    echo Html::submitButton(
                        Module::t('amosproject_management', 'Create') . Html::tag('span', '', ['class' => 'am am-chevron-right']),
//                            '<span class="am glyphicon-chevron-right" aria-hidden="true"></span>',
                        [
                            'class' => 'btn btn-navigation-primary pull-right',
                            'id' => 'button-arrow'
                        ]
                    );
                } catch (InvalidConfigException $e) {
                }
                ?>
            </div>


            <?php
            //        else:
            //            echo Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_NO_COMMUNITY');
            //            $model->select = 0;
            //            echo $form->field($model, 'select')->hiddenInput()->label(false);
            endif;
            ?>
        </div>
        <div class="col-xs-12 btn-wizard-footer nop">
            <div class="form-group">
                <?php
                //            try {
                //                $labelForward = Module::t('amosproject_management', '#NEW_PROJECT_FORWARD');
                //                echo Html::submitButton(
                //                    $labelForward . ' <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                //                    ['class' => 'btn btn-navigation-primary pull-right']);
                //            } catch (InvalidConfigException $e) {
                //            }
                ?>

                <?= Html::a(Module::t('amosproject_management', '#NEW_PROJECT_EXIT'), ['exit'], ['class' => 'btn btn-secondary pull-left annulla']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
</section>
