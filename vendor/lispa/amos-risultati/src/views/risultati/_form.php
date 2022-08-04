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
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\risultati\models\Risultati $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="risultati-form col-xs-12 nop">
    
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'risultati_' . ((isset($fid)) ? $fid : 0),
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
        <div class="col-lg-6 col-sm-6"><!-- stato string -->
            <?= $form->field($model, 'stato')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6 col-sm-6"><!-- titolo_dellinnovazione string -->
            <?= $form->field($model, 'titolo_dellinnovazione')->textInput(['maxlength' => true]) ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- sommario text -->
            <?= $form->field($model, 'sommario')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'sommario' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- e_una_innovazione_prevalenteme string -->
            <?=
            $form->field($model, 'e_una_innovazione_prevalenteme')->widget(Select2::className(), [
                'options' => ['disabled' => FALSE],
                'data' => ArrayHelper::map(\lispa\amos\risultati\models\RisultatiInnovazionePrevalente::find()->orderBy('ordinal')->asArray()->all(), 'id', 'nome')
            ]);
            ?>
        </div>
        <div class="col-lg-6 col-sm-6"><?php
            if (\Yii::$app->getUser()->can('TECNOLOGIERISULTATI_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = NULL;
            }
            ?><?=
            $form->field($model, 'attrTecnologieRisultatiMm')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\lispa\amos\risultati\models\TecnologieRisultati::find()->asArray()->all(), 'id', 'denominazione'),
                'language' => 'it',
                'options' => ['multiple' => false,
                    'id' => 'TecnologieRisultati' . $fid,
                    'placeholder' => AmosRisultati::t('amosrisultati', 'Seleziona') . ' ...',
                    'class' => 'dynamicCreation' . $append,
                    'data-model' => 'tecnologie_risultati',
                    'data-field' => 'denominazione',
                    'data-module' => 'risultati',
                    'data-entity' => 'tecnologie-risultati',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "select2:open" => "dynamicInsertOpening"
                ]
            ])->label(AmosRisultati::t('amosrisultati', 'Le tecnologie utilizzate per raggiungere il r'))
            ?> </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- coerenza_ads_tag decimal -->
            <?= $form->field($model, 'coerenza_ads_tag')->textInput(['maxlength' => true]) ?></div>
        <div class="col-lg-6 col-sm-6"><?php
            if (\Yii::$app->getUser()->can('STADIOSVILUPPORISULTATI_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = NULL;
            }
            ?><?=
            $form->field($model, 'attrStadioSviluppoRisultatiMm')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\lispa\amos\risultati\models\StadioSviluppoRisultati::find()->asArray()->all(), 'id', 'denominazione'),
                'language' => 'it',
                'options' => ['multiple' => false,
                    'id' => 'StadioSviluppoRisultati' . $fid,
                    'placeholder' => AmosRisultati::t('amosrisultati', 'Seleziona') . ' ...',
                    'class' => 'dynamicCreation' . $append,
                    'data-model' => 'stadio_sviluppo_risultati',
                    'data-field' => 'denominazione',
                    'data-module' => 'risultati',
                    'data-entity' => 'stadio-sviluppo-risultati',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "select2:open" => "dynamicInsertOpening"
                ]
            ])->label(AmosRisultati::t('amosrisultati', 'Stadio attuale di sviluppo dell’innovazione'))
            ?> </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><!-- referente decimal -->
            <?=
            $form->field($model, 'referente')->widget(Select2::className(), [
                'options' => ['disabled' => FALSE],
                'data' => ArrayHelper::map(\lispa\amos\admin\models\UserProfile::find()->select(['user_id', "CONCAT(nome, ' ', cognome) AS nomecognome"])->asArray()->all(), 'user_id', 'nomecognome')
            ]);
            ?>
        </div>
        <div class="col-lg-6 col-sm-6"><!-- sito_web_per_approfondimento_p string -->
            <?= $form->field($model, 'sito_web_per_approfondimento_p')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- cosa_ce_oggi_che_prima_non_cer text -->
            <?= $form->field($model, 'cosa_ce_oggi_che_prima_non_cer')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'cosa_ce_oggi_che_prima_non_cer' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- e_importante_sapere_anche_ques text -->
            <?= $form->field($model, 'e_importante_sapere_anche_ques')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'e_importante_sapere_anche_ques' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- qual_e_attualmente_il_mercato_ text -->
            <?= $form->field($model, 'qual_e_attualmente_il_mercato_')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'qual_e_attualmente_il_mercato_' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- ce_un_mercato_geografico_di_ri text -->
            <?= $form->field($model, 'ce_un_mercato_geografico_di_ri')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'ce_un_mercato_geografico_di_ri' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-12"><!-- in_che_modo_il_lavoro_in_partn text -->
            <?= $form->field($model, 'in_che_modo_il_lavoro_in_partn')->widget(yii\redactor\widgets\Redactor::className(), [
                'options' => [
                    'id' => 'in_che_modo_il_lavoro_in_partn' . $fid,
                ],
                'clientOptions' => [
                    'lang' => 'it',
                    'plugins' => ['clips', 'fontcolor', 'imagemanager'],
                    'buttons' => ['format', 'bold', 'italic', 'deleted', 'lists', 'image', 'file', 'link', 'horizontalrule'],
                ],
            ]);
            ?></div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><?php
            if (\Yii::$app->getUser()->can('PROTEZIONEINNOVAZIONERISULTATI_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = NULL;
            }
            ?><?=
            $form->field($model, 'attrProtezioneInnovazioneRisultatiMm')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\lispa\amos\risultati\models\ProtezioneInnovazioneRisultati::find()->asArray()->all(), 'id', 'denominazione'),
                'language' => 'it',
                'options' => ['multiple' => false,
                    'id' => 'ProtezioneInnovazioneRisulta' . $fid,
                    'placeholder' => AmosRisultati::t('amosrisultati', 'Seleziona') . ' ...',
                    'class' => 'dynamicCreation' . $append,
                    'data-model' => 'protezione_innovazione_risulta',
                    'data-field' => 'denominazione',
                    'data-module' => 'risultati',
                    'data-entity' => 'protezione-innovazione-risulta',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "select2:open" => "dynamicInsertOpening"
                ]
            ])->label(AmosRisultati::t('amosrisultati', 'La componente innovativa è protetta attravers'))
            ?> </div>
        <div class="col-lg-6 col-sm-6"><!-- qual_e_laziendaorganismo_di_ri decimal -->
            <?= $form->field($model, 'qual_e_laziendaorganismo_di_ri')->textInput(['maxlength' => true]) ?>
            <?=
            $form->field($model, 'qual_e_laziendaorganismo_di_ri')->widget(Select2::className(), [
                'options' => ['disabled' => FALSE],
                'data' => ArrayHelper::map(\lispa\amos\organizzazioni\models\Aziende::find()->asArray()->all(), 'id', 'denominazione')
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-sm-6"><?php
            if (\Yii::$app->getUser()->can('BISOGNOPERSVILUPPORISULTATI_CREATE')) {
                $append = ' canInsert';
            } else {
                $append = NULL;
            }
            ?><?=
            $form->field($model, 'attrBisognoPerSviluppoRisultatiMm')->widget(Select2::className(), [
                'data' => ArrayHelper::map(\lispa\amos\risultati\models\BisognoPerSviluppoRisultati::find()->asArray()->all(), 'id', 'denominazione'),
                'language' => 'it',
                'options' => ['multiple' => false,
                    'id' => 'BisognoPerSviluppoRisultati' . $fid,
                    'placeholder' => AmosRisultati::t('amosrisultati', 'Seleziona') . ' ...',
                    'class' => 'dynamicCreation' . $append,
                    'data-model' => 'bisogno_per_sviluppo_risultati',
                    'data-field' => 'denominazione',
                    'data-module' => 'risultati',
                    'data-entity' => 'bisogno-per-sviluppo-risultati',
                    'data-toggle' => 'tooltip'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "select2:open" => "dynamicInsertOpening"
                ]
            ])->label(AmosRisultati::t('amosrisultati', 'Di cosa avrebbe bisogno l’innovazione ai fini'))
            ?> </div>
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
