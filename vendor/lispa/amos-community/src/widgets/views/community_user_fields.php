<?php
/**
 * @var $dynamicModel \yii\base\DynamicModel
 * @var $form \lispa\amos\core\forms\ActiveForm
 * @var $modelFieldImages
 */

    foreach ($dynamicModel->attributes() as $attribute) { ?>
        <?php if (!empty($dynamicModel->attributesTypes[$attribute])) { ?>
            <?php if ($dynamicModel->attributesTypes[$attribute] == 'text') { ?>
                <div class="col-lg-12 col-sm-12">
                    <?= $form->field($dynamicModel, $attribute)->textarea(['rows' => 6]) ?>
                </div>
            <?php } else if ($dynamicModel->attributesTypes[$attribute] == 'date') { ?>
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($dynamicModel, $attribute)->widget(\kartik\datecontrol\DateControl::className()) ?>
                </div>
            <?php } else if ($dynamicModel->attributesTypes[$attribute] == 'file') { ?>
                <div class="col-lg-6 col-sm-6">
                    <div class="hidden">
                        <?= $form->field($dynamicModel, $attribute)->hiddenInput(['value' => 'image'])->label(false) ?>
                    </div>
                    <?php
                    echo $form->field($modelFieldImages, 'attachFiles')->widget(\lispa\amos\attachments\components\AttachmentsInput::classname(), [
                        'id' => 'file-input-' . $attribute, // Optional
                        'model' => $modelFieldImages,
                        'options' => [ // Options of the Kartik's FileInput widget
                            'multiple' => false, // If you want to allow multiple upload, default to false
                        ],
                        'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget
                            'maxFileCount' => 10, // Client max files
                            'allowedPreviewTypes' => ['image'],
                            'showPreview' => true,
                        ]
                    ])->label('Image') ?>
                </div>
            <?php } else if ($dynamicModel->attributesTypes[$attribute] == 'html') { ?>
                <div class="col-lg-12 col-sm-12">
                    <?= $form->field($dynamicModel, $attribute)->widget(\lispa\amos\core\forms\TextEditorWidget::className(), [
                        'clientOptions' => [
                            'lang' => substr(Yii::$app->language, 0, 2)
                        ]
                    ]) ?>
                </div>
            <?php } else { ?>
                <div class="col-lg-6 col-sm-6">
                    <?= $form->field($dynamicModel, $attribute)->textInput(['maxlength' => true]) ?>
                </div>
            <?php }
        } ?>

    <?php } ?>