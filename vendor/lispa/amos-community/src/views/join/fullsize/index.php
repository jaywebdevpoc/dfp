<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community
 * @category   CategoryName
 */
use lispa\amos\community\AmosCommunity;
use lispa\amos\community\widgets\icons\WidgetIconAccademyDocument;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\community\utilities\CommunityUtil;

\lispa\amos\dashboard\assets\DashboardFullsizeAsset::register($this);
$this->params['checkedByDefault'] = false;

/**
 * @var $this \yii\web\View
 * @var $model \lispa\amos\community\models\Community
 */
// title not active in layout view_network
//$this->title = AmosCommunity::t('amoscommunity', 'Welcome to the community!');
//if (!is_null($model->parent_id)) {
//    $this->title = AmosCommunity::t('amoscommunity', '#welcome_to_subcommunity');
//}
?>
<div class="actions-dashboard-container community-dashboard-container">
    <nav>
        <div class="container-custom">
            <div class="wrap-plugins row">
                <div id="widgets-icon" class="widgets-icon col-xs-12" role="menu">
                    <?php if ($model->hide_participants == 0 && $model->showParticipantWidget()) { ?>
                        <?php
                        $urlDisplayParticipantsMm = '';
                        $showBox                  = true;
                        if ($model->context == 'lispa\amos\events\models\Event') {
                            $urlDisplayParticipantsMm = "/events/event/participants?communityId={$model->id}";
                            if (method_exists(new \lispa\amos\events\utility\EventsUtility(),
                                    'hasPrivilegesLoggedUser')) {
                                $showBox = false;
                                $event   = \lispa\amos\events\models\Event::findOne(['community_id' => $model->id]);
                                if ($event) {
                                    $showBox = \lispa\amos\events\utility\EventsUtility::hasPrivilegesLoggedUser($event);
                                }
                            } else {
                                $showBox = true;
                            }
                        } else {
                            $urlDisplayParticipantsMm = "/community/community/participants?communityId={$model->id}";
                        }
                        if ($showBox) :
                            ?>

                            <?php
                            if (
                                \Yii::$app->getModule('community')->showCommunitiesParticipantPluging == true
                                ||
                                (\Yii::$app->getModule('community')->showCommunitiesParticipantPluging == false && CommunityUtil::loggedUserIsCommunityManager($model->id))) :
                                ?>
                                <div class="square-box" data-code="lispa\amos\admin\widgets\icons\WidgetIconUserProfile">
                                    <div class="square-content item-widget plugin-partecipants">
                                        <a class="dashboard-menu-item" href="<?= $urlDisplayParticipantsMm ?>"
                                           title=<?= AmosCommunity::t('amoscommunity', "#platform_user_list") ?> role="menuitem"
                                           class="sortableOpt1">
                                            <span class="badge"></span>
                                            <span class="">
                                                <?=
                                                AmosIcons::show('user', [], AmosIcons::IC)
                                                ?>
                                                <span class="icon-dashboard-name pluginName">
                                                    <?=
                                                    AmosCommunity::tHtml('amoscommunity', 'Participants')
                                                    ?>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php } ?>

                    <?php
                    if (\Yii::$app->getModule('community')->showSubcommunitiesWidget === true && $model->showSubCommunityWidget()) {
                        $widgetSubcommunities = Yii::createObject($model->getPluginWidgetClassname());
                        echo $widgetSubcommunities::widget();
                    }
                    if ($model->context == 'lispa\amos\projectmanagement\models\Projects') {
                        /** @var \lispa\amos\core\record\Record $contentObject */
                        $contentObject   = Yii::createObject(lispa\amos\projectmanagement\models\Projects::className());
                        $widgetClassname = $contentObject->getPluginWidgetClassname();
                        $widget          = Yii::createObject($widgetClassname);
                        echo $widget::widget();
                    }
                    ?>

                    <?php
                    echo \lispa\amos\dashboard\widgets\SubDashboardWidget::widget([
                        'model' => $model,
                        'widgets_type' => 'ICON',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="community-description">
        <div class="container-custom">
            <?= $model->description ?>
        </div>
    </div>

    <?php
    echo \lispa\amos\dashboard\widgets\SubDashboardFullsizeWidget::widget([
        'model' => $model,
        'widgets_type' => 'GRAPHIC',
    ]);
    ?>


</div>
