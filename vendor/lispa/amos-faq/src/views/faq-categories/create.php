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
 * @var lispa\amos\faq\models\FaqCategories $model
 */

$this->title = AmosFaq::t('amosfaq', 'Crea categoria', [
    'modelClass' => 'Faq Categories',
]);
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Faq'), 'url' => ['/src/src']];
$this->params['breadcrumbs'][] = ['label' => AmosFaq::t('amosfaq', 'Categorie'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-categories-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
