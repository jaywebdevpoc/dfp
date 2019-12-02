<?php

use lispa\amos\core\helpers\Html;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\Module;

/**
 * @var \yii\data\ActiveDataProvider $organizationDataProvider
 * @var integer $projectId
 */

?>

<div>
    <div class="intestazione-box">
        <?php Html::tag('h3',
            \lispa\amos\projectmanagement\Module::tHtml('amosproject_management', 'Organizations')) ?>
    </div>

    <?php
    if ($organizationDataProvider->totalCount > 0):

        try {
            $view = $this;
            echo \lispa\amos\core\views\AmosGridView::widget([
                'dataProvider' => $organizationDataProvider,
                'columns' => [
                    [
                        'attribute' => 'nameField',
                        'label' => Module::t('amosproject_management', 'Organization'),
                    ],
                    [
                        'attribute' => 'addressField',
                        'label' => Module::t('amosproject_management', 'Address'),
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Subscribe'),
                        'value' => function ($model) use ($projectId, $view) {
                            /** @var \lispa\amos\core\interfaces\OrganizationsModelInterface $modal */
                            $model->id;
                            /** @var \yii\db\ActiveQuery $query */
                            $query = \lispa\amos\projectmanagement\models\ProjectsTasks::find();
                            $query->joinWith('projectsTasksJoinedOrganizationsMms');
                            $query->joinWith('projectsTasksProjectsActivitiesMms.projectsActivities.projectsActivitiesProjectsMms');
                            $query->andWhere([
                                'projects_activities_projects_mm.projects_id' => $projectId,
                                'projects_tasks_joined_organization_mm.organization_id' => $model->id
                            ]);
                            $dataProvider = new \yii\data\ActiveDataProvider([
                                'query' => $query,
                            ]);

                            return $this->render('_modal_organizations_task', [
                                'dataProvider' => $dataProvider,
                                'organizationName' => $model->nameField,
                            ]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'label' => Module::t('amosproject_management', 'Responsible'),
                        'value' => function ($model) use ($projectId, $view) {
                            /** @var \lispa\amos\core\interfaces\OrganizationsModelInterface $modal */
                            $model->id;
                            /** @var \yii\db\ActiveQuery $queryActivities */
                            $queryActivities = \lispa\amos\projectmanagement\models\ProjectsActivities::find();
                            $queryActivities->joinWith('organization');
                            $queryActivities->joinWith('projectsActivitiesProjectsMms');
                            $queryActivities->andWhere([
                                'projects_activities_projects_mm.projects_id' => $projectId,
                                'projects_activities_organization_mm.organization_id' => $model->id
                            ]);
                            $dataProviderActivities = new \yii\data\ActiveDataProvider([
                                'query' => $queryActivities,
                            ]);

                            /** @var \yii\db\ActiveQuery $queryTask */
                            $queryTask = \lispa\amos\projectmanagement\models\ProjectsTasks::find();
                            $queryTask->joinWith('organization');
                            $queryTask->joinWith('projectsActivities.projects');
                            $queryTask->andWhere([
                                'projects.id' => $projectId,
                                'projects_tasks_organization_mm.organization_id' => $model->id
                            ]);

                            $dataProviderTasks = new \yii\data\ActiveDataProvider([
                                'query' => $queryTask,
                            ]);

                            return $this->render('_modal_organizations_activities', [
                                'dataProviderActivities' => $dataProviderActivities,
                                'dataProviderTasks' => $dataProviderTasks,
                                'organizationName' => $model->nameField,
                            ]);
                        },
                        'format' => 'raw'
                    ],
                ],
            ]);
        } catch (Exception $e) {
            pr($e->getMessage(), 'ERROR');
        }
    else:
        ?>
        <div class="text-info bg-info text-center">
            <?= Module::t('amosproject_management', 'The participating organizations are those that will be indicated in the various activities of the work plan. After inserting them they will appear (automatically) in this list.') ?>
        </div>
        <?php
    endif;
    ?>
</div>