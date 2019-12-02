<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\expressions-of-interest
 * @category   CategoryName
 */

use lispa\amos\partnershipprofiles\Module;

/**
 * @var yii\web\View $this
 * @var lispa\amos\partnershipprofiles\models\ExpressionsOfInterest $model
 * @var lispa\amos\partnershipprofiles\models\PartnershipProfiles $partnershipProfile
 */

$this->title = Module::t('amospartnershipprofiles', 'Update expression of interest');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="<?= Yii::$app->controller->id ?>-update">
    <?= $this->render('_form', [
        'model' => $model,
        'partnershipProfile' => $partnershipProfile,
    ]) ?>
</div>
