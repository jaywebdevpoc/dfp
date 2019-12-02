<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\partnershipprofiles\views\expressions-of-interest
 * @category   CategoryName
 */

use lispa\amos\core\forms\ContextMenuWidget;
use lispa\amos\core\forms\ItemAndCardHeaderWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\partnershipprofiles\controllers\ExpressionsOfInterestController;
use lispa\amos\partnershipprofiles\Module;
use lispa\amos\partnershipprofiles\utility\PartnershipProfilesUtility;

/**
 * @var \lispa\amos\partnershipprofiles\models\ExpressionsOfInterest $model
 */

/** @var ExpressionsOfInterestController $appController */
$appController = Yii::$app->controller;

?>
<div class="listview-container">
    <div class="<?= Yii::$app->controller->id ?> post-horizonatal">
        <div class="post-header media nop col-xs-12 col-sm-7">
            <?= ItemAndCardHeaderWidget::widget([
                'model' => $model,
                'publicationDateField' => 'created_at'
            ]) ?>
        </div>
        <div class="col-sm-7 col-xs-12 nop">
            <div class="post-content col-xs-12 nop">
                <div class="post-title col-xs-10">
                    <?= Yii::$app->formatter->asHtml($model->partnership_offered) ?>
                </div>
                <?= ContextMenuWidget::widget([
                    'model' => $model,
                    'actionModify' => "/partnershipprofiles/expressions-of-interest/update?id=" . $model->id,
                    'actionDelete' => "/partnershipprofiles/expressions-of-interest/delete?id=" . $model->id
                ]) ?>
                <div class="clearfix"></div>
                <?php if ($appController->viewReadAllBtn($model)): ?>
                    <div class="row nom post-wrap">
                        <div class="post-text col-xs-12">
                            <p>
                                <?= Html::a(Module::tHtml('amospartnershipprofiles', 'Read all'), $model->getFullViewUrl(), [
                                    'class' => 'underline',
                                    'title' => Module::t('amospartnershipprofiles', 'Read the expression of interest')
                                ]) ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="post-footer col-xs-12 nop">
                    <div class="post-info">
                        <div>
                            <label><?= $model->getAttributeLabel('status') ?>:</label>
                            <?= $model->getWorkflowStatus()->getLabel() ?>
                        </div>
                        <div>
                            <label><?= Module::tHtml('amospartnershipprofiles', 'Creator') ?>:</label>
                            <?= $model->createdUserProfile ?>
                        </div>
                        <div>
                            <label><?= Module::tHtml('amospartnershipprofiles', 'Creation date') ?>:</label>
                            <?= \Yii::$app->getFormatter()->asDatetime($model->created_at) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sidebar col-sm-5 col-xs-12">
            <div class="container-sidebar">
                <h4 class="title m-l-10">
                    <?= Module::tHtml('amospartnershipprofiles', 'Partnership Profile') ?>
                </h4>
                <hr>
                <div class="box">
                    <span>
                        <label><?= $model->partnershipProfile->getAttributeLabel('title') ?>:</label>
                        <?= $model->partnershipProfile->title ?>
                    </span>
                    <br>
                    <span>
                        <label><?= $model->partnershipProfile->getAttributeLabel('status') ?>:</label>
                        <?= $model->partnershipProfile->getWorkflowStatus()->getLabel() ?>
                    </span>
                    <br>
                    <span>
                        <label><?= $model->partnershipProfile->getAttributeLabel('partnership_profile_date') ?>:</label>
                        <?= \Yii::$app->getFormatter()->asDate($model->partnershipProfile->partnership_profile_date) ?>
                    </span>
                    <br>
                    <span>
                        <label><?= Module::t('amospartnershipprofiles', 'Calculated Expiry Date') ?>:</label>
                        <?= PartnershipProfilesUtility::calcExpiryDateStr($model->partnershipProfile, true) ?>
                    </span>
                    <br>
                    <span>
                        <label><?= Module::tHtml('amospartnershipprofiles', 'Creator') ?>:</label>
                        <?= $model->partnershipProfile->createdUserProfile->nomeCognome ?>
                    </span>
                    <br>
                    <span>
                        <label><?= Module::tHtml('amospartnershipprofiles', 'Facilitator') ?>:</label>
                        <?= (!is_null($model->partnershipProfile->partnershipProfileFacilitator) ? $model->partnershipProfile->partnershipProfileFacilitator->nomeCognome : '--') ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
