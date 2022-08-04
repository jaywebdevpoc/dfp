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

use lispa\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var lispa\amos\faq\models\Faq $model
 */

$this->title = AmosFaq::t('amosfaq', 'Crea {modelClass}', [
    'modelClass' => 'Faq',
]);
$this->params['breadcrumbs'][] = ['label' =>AmosFaq::t('amosfaq', 'Faq'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
