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
use lispa\amos\faq\AmosFaq;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\FaqStatoSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="faq-stato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'descrizione') ?>

    <?php // $form->field($model, 'created_at') ?>

    <?php // $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'version') ?>

    <div class="form-group">
        <?= Html::submitButton(AmosFaq::t('amosfaq', 'Cerca'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(AmosFaq::t('amosfaq', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
