<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\myactivities\widgets\views
 * @category   CategoryName
 */

use lispa\amos\admin\AmosAdmin;
use lispa\amos\admin\widgets\UserCardWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\myactivities\AmosMyActivities;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\admin\models\UserProfile $userProfile
 * @var \lispa\amos\core\record\Record $model
 * @var string $validationRequestTime
 * @var string $labelKey
 */

?>

<div class="col-md-3 col-xs-5 wrap-user">
    <?= UserCardWidget::widget(['model' => $userProfile]) ?>
    <span class="user"><?= $userProfile->getNomeCognome() ?></span>
    <br>
    <?= AmosAdmin::t('amosadmin', $userProfile->workflowStatus->label) ?>
</div>
<div class="col-md-5 col-xs-5 wrap-report">
    <div class="col-lg-12 col-xs-12">
        <strong><?= $labelKey ?></strong>
    </div>
    <div class="col-lg-12 col-xs-12">
        <?= Yii::$app->formatter->asDatetime($requestTime) ?>
    </div>
    <div class="col-lg-12 col-xs-12">
        <?= AmosMyActivities::t('amosmyactivities', ' asks connection for:'); ?>
        <?php /** @var \lispa\amos\core\interfaces\ContentModelInterface $model */ ?><br>
        <?= $model->getSearchString() ?>
    </div>
    <div class="col-lg-12 col-xs-12">
        <?php /** @var \lispa\amos\core\interfaces\ViewModelInterface $model */ ?>
        <?= Html::a(AmosIcons::show('search', [], 'dash') . ' <span>' . AmosMyActivities::t('amosmyactivities',
                'View card') . '</span>', $model->getFullViewUrl()
//            Yii::$app->urlManager->createUrl([
//                '/community/community/view',
//                'id' => $model->id
//            ])
        ) ?>
    </div>
</div>
