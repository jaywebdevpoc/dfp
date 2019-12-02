<?php

use lispa\amos\community\AmosCommunity;
use lispa\amos\community\models\CommunityUserMm;
use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\models\MembershipType;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;
use yii\bootstrap\Modal;

/**
 * @var Projects $model
 */

/** @var array $communityRoles */
$communityRoles = $model->communityRoleByUser;
$currentRoleName = end($communityRoles);
$currentRoleId = reset($communityRoles);
?>
<style>
    /*TODO DELETE*/
    .shared > table {
        display: block;
    }
</style>
<div class="listview-container">
    <div class="project-management-item post-horizonatal">
        <div class="post-header media nop col-xs-12 col-sm-7">
            <!-- TODO use widget to show creator -->
        </div>
        <div class="col-sm-7 col-xs-12 nop">
            <div class="post-content col-xs-12 nop">
                <div class="post-title col-xs-10">
                    <h3><?= $model->name ?></h3>
                </div>
                <?php
                try {
                    echo \lispa\amos\core\forms\ContextMenuWidget::widget([
                        'model' => $model,
                        'actionModify' => "/project_management/projects/update?id=" . $model->id,
                        'actionDelete' => "/project_management/projects/delete?id=" . $model->id,
                        'labelDeleteConfirm' => Module::t('amosproject_management', 'If you proceed with this action, the ACTIVITIES PLAN associated with the project will also be deleted. Are you sure you want to delete this item?')
                    ]);
                } catch (Exception $e) {
                } ?>
                <div class="clearfix"></div>

                <div class="row nom post-wrap">
                    <div class="col-sm-5 col-xs-12">
                        <img class="img-responsive"
                             src="<?= $model->logo ? $model->logo->getUrl('square_large', false, true) : '/img/img_default.jpg'; ?>"
                             alt="<?= $model->name ?>"/>
                    </div>
                    <div class="post-text">
                        <p>
                            <?= $model->insights; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="post-footer col-xs-12 nop">
                <div class="post-info">
                    <?php if ($model->organization): ?>
                        <span class="bold"><?= \yii\helpers\Html::label($model->getAttributeLabel('organization')) ?>
                            :</span>
                        <span><?= $model->organization->getNameField() ?></span>
                        <br>
                    <?php endif; ?>
                    <?php if ($model->projectsStates): ?>
                        <span class="bold"><?= \yii\helpers\Html::label($model->getAttributeLabel('projectsStates')) ?>
                            :</span>
                        <span><?= Module::tHtml('amosproject_management', $model->projectsStates->name) ?></span>
                        <br>
                    <?php endif; ?>
                    <?php if ($currentRoleName): ?>
                        <span class="bold"><?= Module::tHtml('amosproject_management', 'Project Role') ?>:</span>
                        <span><?= $currentRoleName ?></span>
                        <br>
                    <?php endif; ?>
                    <?php if ($model->hasWorkflowStatus()): ?>
                        <span class="bold"><?= Module::tHtml('amosproject_management', 'Progress Status') ?>:</span>
                        <span><?= Module::t('amosproject_management', $model->getWorkflowStatus()->label) ?></span>
                        <br>
                    <?php endif; ?>
                </div>
                <!--div class="shared">
                    <table class="pull-left">
                        <tbody>
                        <tr class="">
                            <td><?= AmosIcons::show('label') ?> <span>2</span></td>
                        </tr>
                        </tbody>
                    </table>
                </div-->
            </div>
        </div>
        <div class="sidebar col-sm-5 col-xs-12">
            <h4 class="title"></h4>
            <div class="container-sidebar">
                <div class="box">
                    <div class="media">
                        <div class="media-left">
                            <p class="number-partecipanti"><?= $model->getNumberAllOrganizations(); ?></p>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Module::tHtml('amosproject_management',
                                    'Joined Organizations') ?></h4>
                            <?= Module::tHtml('amosproject_management',
                                'The participating organizations are empowered to collaborate on the project') ?>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <p class="number-partecipanti"><?= count($model->activeCommunityMembers); ?></p>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?= Module::tHtml('amosproject_management',
                                    'Collaborators') ?></h4>
                            <?= Module::tHtml('amosproject_management',
                                'Collaborators contribute to the community and the advancement of the project') ?>
                        </div>
                    </div>
                </div>

                <div class="footer_sidebar col-xs-12">
                    <?php if (ProjectManagementUtility::viewActivityPlanButton($currentRoleId)): ?>
                        <?php $planningTitle = Module::t('amosproject_management', 'Activity Plan'); ?>
                        <?php if (ProjectManagementUtility::editActivityPlan($currentRoleId)): ?>
                            <?php $planningTitle = Module::t('amosproject_management', 'Edit Activity Plan'); ?>
                        <?php elseif (ProjectManagementUtility::seeActivityPlan($currentRoleId)): ?>
                            <?php $planningTitle = Module::t('amosproject_management', 'See Activity Plan'); ?>
                        <?php endif; ?>
                        <?= \yii\helpers\Html::a($planningTitle,
                            ['/project_management/projects/by-project', 'id' => $model->id],
                            ['class' => 'btn btn-primary ']) ?>
                    <?php endif; ?>

                    <?php
                    $viewTitle = Module::t('amosproject_management', 'View project');
                    echo \yii\helpers\Html::a($viewTitle,
                        ['/project_management/projects/view', 'id' => $model->id],
                        ['class' => 'btn btn-primary ']);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
