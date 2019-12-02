<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\partnership-profiles
 * @category   CategoryName
 */

use lispa\amos\partnershipprofiles\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\partnershipprofiles\models\PartnershipProfiles $model
 */

$this->title = Module::t('amospartnershipprofiles', 'Update');
$this->params['breadcrumbs'][] = ['label' => Module::t('amospartnershipprofiles', 'Partnership Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Yii::$app->controller->id ?>-update">
    <?= $this->render('_form', [
        'model' => $model,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null
    ]) ?>
</div>
