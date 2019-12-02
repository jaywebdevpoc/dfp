<?php
use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;

/**
 * @var lispa\amos\projectmanagement\models\Projects $model
 * @var boolean $onlyView
 */

if (!isset($onlyView)) {
    $onlyView = false;
}
?>

<div>
    <div class="intestazione-box">
        <?php
//        Html::tag('h3', \lispa\amos\projectmanagement\Module::tHtml('amosproject_management', 'Participants'))
        ?>
    </div>

    <?php
        try {
            $community = $model->community;
            if($community) {
                $query = $community->getCommunityUserMms();
                $dataProvider = new \yii\data\ActiveDataProvider([
                    'query' => $query,
                ]);

                echo \lispa\amos\core\views\AmosGridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'Photo' => [
                            'headerOptions' => [
                                'id' => Module::t('amoscommunity', 'Photo'),
                            ],
                            'contentOptions' => [
                                'headers' => Module::t('amoscommunity', 'Photo'),
                            ],
                            'label' => Module::t('amoscommunity', 'Photo'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                /** @var \lispa\amos\admin\models\UserProfile $userProfile */
                                $userProfile = $model->user->getProfile();
                                return \lispa\amos\admin\widgets\UserCardWidget::widget(['model' => $userProfile]);
                            }
                        ],
                        'name' => [
                            'attribute' => 'user.userProfile.surnameName',
                            'label' => Module::t('amoscommunity', 'Name'),
                            'headerOptions' => [
                                'id' => Module::t('amoscommunity', 'name'),
                            ],
                            'contentOptions' => [
                                'headers' => Module::t('amoscommunity', 'name'),
                            ],
                            'value' => function ($model) {
                                return Html::a($model->user->userProfile->surnameName, ['/admin/user-profile/view', 'id' => $model->user->userProfile->id], [
                                    'title' => Module::t('amoscommunity', 'Apri il profilo di {nome_profilo}', ['nome_profilo' => $model->user->userProfile->surnameName])
                                ]);
                            },
                            'format' => 'html'
                        ],
                        'status' => [
                            'attribute' => 'status',
                            'label' => Module::t('amoscommunity', 'Status'),
                            'headerOptions' => [
                                'id' => Module::t('amoscommunity', 'Status'),
                            ],
                            'contentOptions' => [
                                'headers' => Module::t('amoscommunity', 'Status'),
                            ],
                            'value' => function ($model) {
                                return $model->status;
                            }
                        ],
                        'role' => [
                            'attribute' => 'role',
                            'label' => Module::t('amoscommunity', 'Role'),
                            'headerOptions' => [
                                'id' => Module::t('amoscommunity', 'Role'),
                            ],
                            'contentOptions' => [
                                'headers' => Module::t('amoscommunity', 'Role'),
                            ],
                            'value' => function ($model) {
                                return Projects::getPmRole($model->role);
                            }
                        ],
                    ]

                ]);
            }

        } catch (Exception $e) {
            pr($e->getMessage(),'ERROR');
        }
    ?>
</div>
