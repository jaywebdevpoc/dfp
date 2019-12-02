<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\core\views\DataProviderView;
use lispa\amos\projectmanagement\Module;
use lispa\amos\projectmanagement\utility\ProjectManagementUtility;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model
 * @var string $currentView
 */

$this->params['textHelp']['filename'] = 'community_projects_description';

?>

<div class="projects-index">
    <?php echo $this->render('_search', ['model' => $model]); ?>

    <p>
        <?php /* echo         Html::a('Nuovo Projects'        , ['create'], ['class' => 'btn btn-administration-primary'])*/ ?>
    </p>

    <?php

    try {
        echo DataProviderView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $model,
            'currentView' => $currentView,
            'listView' => [
                'itemView' => '_item',
                'masonry' => false,
            ],
            'gridView' => [
                'columns' => [
                    'name',
                    'organization' => [
                        'attribute' => 'organization',
                        'format' => 'html',
                        'label' => Module::t('amosproject_management', 'Leader Organization'),
                        'value' => function ($model) {
                            /** @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model */
                            return strip_tags($model->getattrOrganizationMm(','));
                        }
                    ],
                    'projectsStates' => [
                        'attribute' => 'projectsStates',
                        'format' => 'html',
                        'label' => Module::t('amosproject_management', 'Progress Status'),
                        'value' => function ($model) {
                            /** @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model */
                            return strip_tags($model->getAttrProjectsStatesMm(','));
                        }
                    ],
                    'projectsRole' => [
                        'attribute' => 'projectsRole',
                        'format' => 'html',
                        'label' => Module::t('amosproject_management', 'Project Role'),
                        'value' => function ($model) {
                            $communityRoles = $model->communityRoleByUser;
                            $currentRoleName = end($communityRoles);

                            /** @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model */
                            return $currentRoleName;
                        }
                    ],
                    [
                        'class' => 'lispa\amos\core\views\grid\ActionColumn',
                        'template' => '{community} {manageActivities} {update} {delete}',
                        'buttons' => [
                            'manageActivities' => function ($url, $model) {
                                /** @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model */
                                $createUrlParams = [
                                    '/project_management/projects-activities/by-project',
                                    'pid' => $model->id
                                ];
                                /** @var array $communityRoles */
                                $communityRoles = $model->communityRoleByUser;
                                $currentRoleId = reset($communityRoles);
                                $btn = '';
                                if (ProjectManagementUtility::viewActivityPlanButton($currentRoleId)) {
                                    $btn = Html::a(
                                        AmosIcons::show('collection-text', ['class' => '']),
                                        Yii::$app->urlManager->createUrl($createUrlParams),
                                        [
                                            'title' => Module::t('amosproject_management', 'Activity Plan'),
                                            'class' => 'btn btn-tools-secondary'
                                        ]
                                    );
                                }
                                return $btn;
                            },
                            'community' => function ($url, $model) {
                                /** @var lispa\amos\projectmanagement\models\search\ProjectsSearch $model */
                                if (!$model->community_id) {
                                    return '';
                                }
                                $createUrlParams = [
                                    '/community/join',
                                    'id' => $model->community_id
                                ];
                                $btn = Html::a(AmosIcons::show('group', ['class' => '']),
                                    Yii::$app->urlManager->createUrl($createUrlParams),
                                    [
                                            'title' => Module::t('amosproject_management', 'Collaborate'),
                                        'class' => 'btn btn-tools-secondary'
                                    ]);
                                return $btn;
                            }
                        ]
                    ],
                ],
            ],
        ]);
    } catch (Exception $e) {
        pr($e->getMessage(), 'ERROR');
    } ?>

</div>
