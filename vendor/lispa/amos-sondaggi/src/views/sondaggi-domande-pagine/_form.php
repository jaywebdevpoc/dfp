<?php

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\forms\CloseSaveButtonWidget;
use lispa\amos\core\forms\CreatedUpdatedWidget;
use lispa\amos\core\forms\editors\FileInput;
use lispa\amos\sondaggi\AmosSondaggi;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\sondaggi\models\SondaggiDomandePagine $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sondaggi-domande-pagine-form">
    
    <?php
    $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
    $customView = Yii::$app->getViewPath() . '/imageField.php';
    ?>
    
    <?php $this->beginBlock('generale'); ?>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <?php if ($model->sondaggi_id && $model->isNewRecord) : ?>
                <?= $form->field($model, 'sondaggi_id')->hiddenInput()->label(FALSE) ?>
                <?= Html::beginTag('div', ['class' => 'form-group field-sondaggio']) ?>
                <?= Html::tag('label', $model->getAttributeLabel('sondaggi_id')) ?>
                <b><?= "<br>" . $model->sondaggi['titolo'] ?></b>
                <?= Html::endTag('div') ?>
            <?php else : ?>
                <?=
                // generated by schmunk42\giiant\generators\crud\providers\RelationProvider::activeField
                $form->field($model, 'sondaggi_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(lispa\amos\sondaggi\models\Sondaggi::find()->all(), 'id', 'titolo'), ['prompt' => AmosSondaggi::t('amossondaggi', 'Seleziona sondaggio ...')]
                );
                ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <?= $form->field($model, 'titolo')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'descrizione')->textarea(['rows' => 6]) ?>
        </div>

        <div class="col-sm-4">
            <div class="col-lg-8 col-sm-8 pull-right">
                <?= $form->field($model,
                    'file')->widget(\lispa\amos\attachments\components\AttachmentsInput::classname(), [
                    'options' => [ // Options of the Kartik's FileInput widget
                        'multiple' => false, // If you want to allow multiple upload, default to false
                        'accept' => "image/*"
                    ],
                    'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget
                        'maxFileCount' => 1,
                        'showRemove' => false,// Client max files,
                        'indicatorNew' => false,
                        'allowedPreviewTypes' => ['image'],
                        'previewFileIconSettings' => false,
                        'overwriteInitial' => false,
                        'layoutTemplates' => false
                    ]
                ])->label(AmosSondaggi::t('amosnews', 'Immagine')) ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php $this->endBlock(); ?>
    
    <?php
    $itemsTab[] = [
        'label' => AmosSondaggi::tHtml('amossondaggi', 'generale '),
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
    <div class="col-xs-12 note_asterisk nop">
        <p>I campi <span class="red">*</span> sono obbligatori.</p>
    </div>
    <?= CreatedUpdatedWidget::widget(['model' => $model]) ?>
    <?= CloseSaveButtonWidget::widget([
        'model' => $model,
        'buttonNewSaveLabel' => $model->isNewRecord ? AmosSondaggi::tHtml('amossondaggi', 'Inserisci') : AmosSondaggi::tHtml('amossondaggi', 'Salva'),
        'closeButtonLabel' => AmosSondaggi::t('amossondaggi', 'Chiudi'),
    ]); ?>
    
    <?php ActiveForm::end(); ?>
</div>
