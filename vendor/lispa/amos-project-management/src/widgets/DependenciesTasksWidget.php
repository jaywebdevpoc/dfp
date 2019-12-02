<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community
 * @category   CategoryName
 */

namespace lispa\amos\projectmanagement\widgets;

use lispa\amos\core\helpers\Html;
use lispa\amos\core\icons\AmosIcons;
use lispa\amos\projectmanagement\controllers\ProjectsTasksController;
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsTasks;
use lispa\amos\projectmanagement\models\ProjectsTasksTasksMm;
use lispa\amos\projectmanagement\Module;
use kartik\select2\Select2;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Class ProjectOrganizationsWidget
 * @package lispa\amos\community\widgets
 */
class DependenciesTasksWidget extends Widget
{
    /**
     * @var Projects $model
     */
    public $model = null;

    /**
     * (eg. ['PARTICIPANT'] - thw widget will show only member with role participant)
     * @var array Array of roles to show
     */
    public $showRoles = null;

    /**
     * @var bool $forceReadOnly
     */
    public $forceReadOnly = false;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (!$this->model) {
            throw new InvalidConfigException($this->throwErrorMessage('model'));
        }
    }

    protected function throwErrorMessage($field)
    {
        return Module::t('amosproject_management', 'Wrong widget configuration: missing field {field}', [
            'field' => $field
        ]);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var ProjectsTasks $model */
        $model = $this->model;
        $forceReadOnly = $this->forceReadOnly;
        //pr($model->getJoinedOrganizations()->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
        $widget = \lispa\amos\core\forms\editors\m2mWidget\M2MWidget::widget([
            'model' => $model,
            'modelId' => $model->id,
            'modelData' => $model->getProjectsRequiredTasksMms(),
            'overrideModelDataArr' => true,
            'forceListRender' => true,
            'createAssociaButtonsEnabled' => true,
            'disableCreateButton' => true,
            'disableAssociaButton' => false,
            'btnAssociaLabel' => Module::t('amosproject_management', 'Create New Dependency'),
            //'createNewBtnLabel' => Module::t('amosproject_management', 'Create New Task'),
            'actionColumnsTemplate' => '{deleteRelation}',
            'deleteRelationTargetIdField' => 'projects_tasks_id',
            'targetUrl' => '/project_management/projects-tasks/associa-m2m',
            'createNewTargetUrl' => '/project_management/projects-tasks/create?activity_id=' . $model->projectsActivities->id . '&task_id=' . $model->id,
            'moduleClassName' => Module::className(),
            'targetUrlController' => 'projects-tasks',
            'postName' => 'Activity',
            'postKey' => 'ProjectsActivities',
            'permissions' => [
                'add' => ($this->forceReadOnly ? null : 'PROJECT_MANAGER'),
            ],
            'actionColumnsButtons' => [
                Html::button('Test')
            ],
            'itemsMittente' => [
                [
                    'attribute' => 'checkStatus',
                    'format' => 'raw',
                    'label' => Module::t('amosproject_management', 'Status'),
                    'value' => function ($model, $index, $dataColumn) {
                        /**
                         * @var $model ProjectsTasksTasksMm
                         */
                        $error = $model->hasDependencyError(true);

                        $icon = $error ? 'alert-triangle' : 'check-circle';
                        $classDanger = $error ? 'text-danger' : 'text-success';

                        $noError = Module::t('amosproject_management', 'Ok');

                        $message = $error ? ProjectsTasksController::getRelationError($model->typeNumber,
                            $model->requiredTasks) : $noError;

                        return AmosIcons::show($icon, ['data-toggle' => "tooltip", 'title' => $message, 'class' => $classDanger . '', 'style' => 'font-size: 25px;']);
                    },
                ],
                [
                    'attribute' => 'typeName',
                    'format' => 'raw',
                    'label' => Module::t('amosproject_management', 'Dependency Type'),
                    'value' => function ($model, $index, $dataColumn)use ($forceReadOnly) {
                        $labelType = [
                            'finish_to_finish' => 'Finish to Finish',
                            'finish_to_start' => 'Finish to Start',
                            'start_to_finish' => 'Start to Finish',
                            'start_to_start' => 'Start to Start'
                        ];

                        if($forceReadOnly) {
                            $type = $model->type;
                            if(!empty($labelType[$type])) {
                                return $labelType[$type];
                            }
                        }
                        else {
                            return Select2::widget([
                                'data' => $labelType,
                                'language' => 'it',
                                'options' => [
                                    'multiple' => false,
                                    'id' => 'Tasks' . $index,
                                    'placeholder' => 'Seleziona ...',
                                ],
                                'name' => "relationType[{$model->id}]",
                                'value' => $model->type,
                                /*'pluginOptions' => [
                                     'allowClear' => true
                                 ],
                                 /*'pluginEvents' => [
                                     "select2:open" => "dynamicInsertOpening"
                                 ]*/
                            ]);
                        }
                        return '';
                    },
                ],
                'activity' => [
                    'attribute' => 'requiredTasks.projectsActivities.name',
                    'label' => Module::t('amosproject_management', 'WP Name'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'WP Name'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'WP Name'),
                    ]
                ],
                'name' => [
                    'attribute' => 'requiredTasks.name',
                    'label' => Module::t('amosproject_management', 'Activity Name'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'Activity Name'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'Activity Name'),
                    ]
                ],
                'start_date' => [
                    'attribute' => 'requiredTasks.start_date',
                    'format' => 'date',
                    'label' => Module::t('amosproject_management', 'Start Date'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'Start Date'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'Start Date'),
                    ]
                ],
                'end_date' => [
                    'attribute' => 'requiredTasks.endDate',
                    'format' => 'date',
                    'label' => Module::t('amosproject_management', 'End Date'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'End Date'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'End Date'),
                    ]
                ],
                'reference_organization' => [
                    'attribute' => 'requiredTasks.organization.nameField',
                    'label' => Module::t('amosproject_management', 'Reference Organization'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'Reference Organization'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'Reference Organization'),
                    ]
                ],
                'duration' => [
                    'attribute' => 'requiredTasks.expDuration',
                    'label' => Module::t('amosproject_management', 'Duration'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'Duration'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'Duration'),
                    ]
                ],
                /*[
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{show}',
                    'buttons' => [
                        'show' => function ($url, $model, $key) {     // render your custom button
                            return Html::a(AmosIcons::show('file'), ['view', 'id' => $model->projects_tasks_id]);
                        }
                    ]
                ]*/
                /*
                'type' => [
                    'attribute' => 'typeName',
                    'label' =>  Module::t('amosproject_management', 'Dependency Type'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'type'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'type'),
                    ]
                ],*/
            ],
        ]);

        return $widget;
    }
}