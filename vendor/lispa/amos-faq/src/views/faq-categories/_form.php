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
use yii\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\FaqCategories $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="faq-categories-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?php $this->beginBlock('generale'); ?>

    <div class="col-lg-6 col-sm-6 nopl">
        
        <?= $form->field($model, 'titolo')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-6 col-sm-6 nopr">
        
        <?= $form->field($model, 'descrizione')->textarea(['rows' => 6]) ?>
    </div>
    <div class="clearfix"></div>
    <?php $this->endBlock('generale'); ?>
    
    <?php $itemsTab[] = [
        'label' => AmosFaq::tHtml('amosfaq', 'Generale '),
        'content' => $this->blocks['generale'],
    ];
    ?>
    
    <?= Tabs::widget(
        [
            'encodeLabels' => false,
            'items' => $itemsTab
        ]
    );
    ?>
    <div class="col-xs-12 note_asterisk nop">
        <p>I campi <span class="red">*</span> sono obbligatori.</p>
    </div>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    <?= CloseSaveButtonWidget::widget(['model' => $model]); ?>
    <?php ActiveForm::end(); ?>
</div>
