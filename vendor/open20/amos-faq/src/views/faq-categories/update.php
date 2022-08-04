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

use open20\amos\faq\AmosFaq;

/**
 * @var yii\web\View $this
 * @var open20\amos\faq\models\FaqCategories $model
 */

$this->title = AmosFaq::t('amosfaq', 'Aggiorna categoria Faq', [
    'modelClass' => 'Faq Categories',
]);
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/src/src']];
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Categorie'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titolo, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = AmosFaq::t('amosfaq', 'Aggiorna');
?>
<div class="faq-categories-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
