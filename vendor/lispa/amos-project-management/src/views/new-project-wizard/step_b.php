<?php
/**
 * @var yii\web\View $this
 * @var \lispa\amos\projectmanagement\models\new_project_wizard\StepB $model
 */

use lispa\amos\projectmanagement\Module;
use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use yii\base\InvalidConfigException;
use lispa\amos\community\models\CommunityUserMm;

\lispa\amos\projectmanagement\assets\AmosProjectManagementAsset::register($this);

$this->title = Module::t('amosproject_management', '#NEW_PROJECT_TITLE_STEP_B');
$this->params['breadcrumbs'][] = ['label' => '', 'hidden' => true];
$dataProvider = $model->getCommunityUsersDataProvider();
/** @var \lispa\amos\community\models\Community $community */
$community = $model->getCommunityStepA();
$moduleCwh = \Yii::$app->getModule('cwh');
if (isset($moduleCwh) && !empty($moduleCwh->getCwhScope())) {
    $scope = $moduleCwh->getCwhScope();
    if (isset($scope['community'])) {
        $communityId = $scope['community'];
        if($communityId == $community->id){
            $hidePrev = true;
        }
    }
}
?>


<section class="step-b">
    <?php $form = ActiveForm::begin([
        'action' => ['', 'nav' => 'next'],
    ]); ?>

<!--    <div class="col-xs-12 nop">-->
<!--        <h2 class="subtitle-wizard">-->
<!--            --><?php//= Module::t('amosproject_management', '#NEW_PROJECT_DESCRIPTION_STEP_B'); ?>
<!--        </h2>-->
<!--    </div>-->
    <div class="col-xs-12 nop">
        <h2 class="subtitle-wizard"><?= Module::t('amosproject_management', '#NEW_PROJECT_USER_TITLE_LABEL', ['communityTitle' => !empty($community) ? $community->name : '']) ?></h2>
    </div>

    <div class="col-xs-12 nop">
        <?php
        try {
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'grid-members',
                'columns' => [
                    'userProfileImage' => [
                        'label' => Module::t('amosproject_management', '#USER_PROFILE_IMAGE'),//$model->getAttributeLabel('userProfileImage'),
                        'format' => 'html',
                        'value' => function ($model) {
                            /** @var \lispa\amos\admin\models\UserProfile $model */

                            return \lispa\amos\admin\widgets\UserCardWidget::widget(['model' => $model]);
                        }
                    ],
                    'nome',
                    'cognome',
                    [
                        'label' => Module::t('amosproject_management', '#NEW_PROJECT_USER_ROLE_TITLE_LABEL'),
                        'value' => function ($model) use ($community) {
                            try {
                                $mm = CommunityUserMm::find()->andWhere([
                                    'community_id' => $community->id,
                                    'user_id' => $model->user_id,
                                ])->one();
                                if (!empty($mm)) {
                                    return Module::t('amosproject_management', $mm->role);
                                }
                                return '';
                            } catch (Exception $e) {
                                return '';
                            }
                        }
                    ],
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage() . ' L:' . $e->getLine(), 'ERROR');
        }
        ?>
    </div>
    <div class="col-xs-12 nop subsection">
        <div class=" col-xs-12 nop subsection-title-container">
            <?= Html::tag('span',Module::t('amosproject_management', '#NEW_PROJECT_STEP_B_DESCRIPTION_ANSWER'),['class' => 'subtitle-wizard']); ?>
        </div>
        <div class="col-xs-12 radio-confirm">
            <p><?= Module::t('amosproject_management', '#NEW_PROJECT_ALL_COMMUNITY_USER_IN_PROJECT_LABEL') ?></p>
            <?php
            echo $form->field($model, 'allCommunityUsersInProject')->radioList($model->getAnswers())->label(false);
            ?>
        </div>
    </div>


    <div class="col-xs-12 btn-wizard-footer nop">
        <div class="form-group">
            <?php
            if(!isset($hidePrev) || !$hidePrev) {
                $labelBack = Module::t('amosproject_management', '#NEW_PROJECT_BACK');
                echo Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> ' . $labelBack,
                    ['wizard', 'nav' => 'prev'], ['class' => 'btn btn-primary pull-left']);
            }
            ?>
            <?php
            try {
                $labelForward = Module::t('amosproject_management', '#NEW_PROJECT_FORWARD');
                echo Html::submitButton(
                    $labelForward . ' <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>',
                    ['class' => 'btn btn-navigation-primary pull-right']);
            } catch (InvalidConfigException $e) {
            } ?>

            <?= Html::a(Module::t('amosproject_management', '#NEW_PROJECT_EXIT'), ['exit'], ['class' => 'btn btn-secondary pull-left annulla']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</section>