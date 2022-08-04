<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\faq\AmosFaq;
use lispa\amos\faq\models\FaqCategories;
use lispa\amos\faq\models\FaqStato;
use lispa\amos\core\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\Faq $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="faq-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?php $this->beginBlock('generale'); ?>

    <div class="col-lg-6 col-sm-6 nopl">
        
        <?= $form->field($model, 'domanda')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-6 col-sm-6 nopr">
        
        <?= $form->field($model, 'risposta')->textarea(['rows' => 6]) ?>
    </div>

    <div class="col-lg-6 col-sm-6 nopl">
        <?php /* $form->field($model, 'faq_stato_id')->textInput() */ ?>
        <?=
        $form->field($model, 'faq_stato_id')->widget(Select2::classname(), [
            'options' => ['placeholder' => AmosFaq::t('amosfaq', 'Selezionare uno stato'), 'disabled' => FALSE],
            'data' => ArrayHelper::map(FaqStato::find()->all(), 'id', 'nome')
        ])->label('Stato');
        ?>

    </div>

    <div class="col-lg-6 col-sm-6 nopr">
        
        <?= $form->field($model, 'order')->textInput() ?>
    </div>

    <div class="col-lg-6 col-sm-6 nopl">
        <?php //$form->field($model, 'faq_categories_id')->textInput()  ?>
        <?=
        $form->field($model, 'faq_categories_id')->widget(Select2::classname(), [
            'options' => ['placeholder' => AmosFaq::t('amosfaq', 'Selezionare una categoria (facoltativo)'), 'disabled' => FALSE],
            'data' => ArrayHelper::map(FaqCategories::find()->all(), 'id', 'titolo')
        ])->label('Categoria');
        ?>
    </div>
    <div class="col-xs-12 note_asterisk nop m-b-25">
        <p>I campi <span class="red">*</span> sono obbligatori.</p>
    </div>
    <div class="col-xs-12 m-t-15 nop">
        
        <?php // pr($model->listaWidget);?>
        <?php
        echo $form->field($model, 'listaWidget')->checkboxList(
            ArrayHelper::map(\lispa\amos\dashboard\models\AmosWidgets::find()->all(), 'classname', 'classname'), [
                'prompt' => AmosFaq::t('amosfaq', 'Selezionare un widget (facoltativo)')
            ]
        );
        ?>
    </div>

    <!--    <div class="col-lg-12 col-sm-12">-->
    <!--        --><?php
    ////        echo $form->field($model, 'rotte')->widget(
    ////            Select2::className(), [
    ////                'name' => $model->rotte,
    ////                'data' => $model->getRotteYii(),
    ////                'options' => ['multiple' => true, 'placeholder' => 'Rotte di assegnazione ...'],
    ////                'pluginOptions' => [
    ////                    'tags' => true,
    ////                    'maximumInputLength' => 10
    ////                ],
    ////            ]
    ////        );
    //        ?>
    <!--    </div>-->
    <div class="clearfix"></div>
    <?php $this->endBlock('generale'); ?>
    
    <?php
    $itemsTab[] = [
        'label' => AmosFaq::t('amosfaq', 'Generale '),
        'content' => $this->blocks['generale'],
    ];
    ?>
    
    <?=
    Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]
    );
    ?>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    
    
    <?php

    $moduleSeo = \Yii::$app->getModule('seo');

    if (isset($moduleSeo)) : ?>
    
        <div class="row">

            <div class="col-xs-12">
                <?= Html::tag('h2', AmosFaq::t('amosfaq', '#settings_seo_title'), ['class' => 'subtitle-form']) ?>
                <div class="col-xs-12 receiver-section">
                    <?=
                    \lispa\amos\seo\widgets\SeoWidget::widget([
                        'contentModel' => $model,
                    ]);
                    ?>
                </div>
            </div>
            <div class="col-xs-12 note_asterisk">
                <span><?= AmosFaq::t('amosfaq', '#required_field') ?></span>
            </div>

        </div>

    <?php endif; ?>

    
    
    <?= CloseSaveButtonWidget::widget(['model' => $model]); ?>
    <?php ActiveForm::end(); ?>
</div>
