<?php

/**
 * Aria S.p.A.
 * OPEN 2.0
 *
 *
 * @package    open20\amos\faq
 * @category   CategoryName
 * @author     Aria S.p.A.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use open20\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var open20\amos\faq\models\FaqSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="faq-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'domanda') ?>

    <?= $form->field($model, 'risposta') ?>

    <?= $form->field($model, 'order') ?>

    <?php // $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'faq_categories_id') ?>

    <?php // echo $form->field($model, 'faq_stato_id') ?>

    <?php echo $form->field($model, 'faq_widgets_id') ?>


    <div class="form-group">
        <?= Html::submitButton(AmosFaq::t('amosfaq', 'Cerca'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(AmosFaq::t('amosfaq', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
