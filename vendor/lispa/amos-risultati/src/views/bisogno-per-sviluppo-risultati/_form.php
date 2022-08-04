<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\risultati
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\Tabs;
use lispa\amos\risultati\AmosRisultati;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\BisognoPerSviluppoRisultati $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="bisogno-per-sviluppo-risultati-form col-xs-12 nop">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'bisogno-per-sviluppo-risultati_' . ((isset($fid)) ? $fid : 0),
            'data-fid' => (isset($fid)) ? $fid : 0,
            'data-field' => ((isset($dataField)) ? $dataField : ''),
            'data-entity' => ((isset($dataEntity)) ? $dataEntity : ''),
            'class' => ((isset($class)) ? $class : '')
        ]
    ]);
    ?>
    <?php // $form->errorSummary($model, ['class' => 'alert-danger alert fade in']); ?>
    <?php $this->beginBlock('generale'); ?>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- denominazione string -->
            <?= $form->field($model, 'denominazione')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-12 col-sm-12"><!-- descrizione text -->
            <?= $form->field($model, 'descrizione')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'descrizione' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="clearfix"></div><?php $this->endBlock(); ?><?php $itemsTab[] = [
        'label' => AmosRisultati::t('amosrisultati', 'Generale'),
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
