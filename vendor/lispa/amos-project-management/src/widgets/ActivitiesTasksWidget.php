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
use lispa\amos\projectmanagement\models\ProjectsActivities;
use lispa\amos\projectmanagement\Module;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Class ProjectOrganizationsWidget
 * @package lispa\amos\community\widgets
 */
class ActivitiesTasksWidget extends Widget
{

    /**
     * @var ProjectsActivities $model
     */
    public $model = null;

    /**
     * (eg. ['PARTICIPANT'] - thw widget will show only member with role participant)
     * @var array Array of roles to show
     */
    public $showRoles = null;

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

        /** @var ProjectsActivities $model */
        $model = $this->model;
        $widget = \lispa\amos\core\forms\editors\m2mWidget\M2MWidget::widget([
            'model' => $model,
            'modelId' => $model->id,
            'modelData' => $model->getProjectsTasks(),
            'createNewBtnLabel' => Module::t('amosproject_management', '#create_new_f'),
            'overrideModelDataArr' => true,
            'forceListRender' => true,
            'createAssociaButtonsEnabled' => true,
            'disableCreateButton' => false,
            'disableAssociaButton' => true,
            'actionColumnsTemplate' => '{view}{update}{deleteRelation}',
            'deleteRelationTargetIdField' => 'id',
            'targetUrl' => '/project_management/projects-activities/associa-m2m',
            'createNewTargetUrl' => '/project_management/projects-tasks/create?activity_id=' . $model->id,
            'moduleClassName' => Module::className(),
            'targetUrlController' => 'projects-activities',
            'postName' => 'Activity',
            'postKey' => 'ProjectsActivities',
            'permissions' => [
                'add' => 'PROJECT_MANAGER',
            ],
            'actionColumnsButtons' => [
                'view' => function ($url, $model) {
                    $url = '/project_management/projects-tasks/view';
                    $urlview = \Yii::$app->urlManager->createUrl([
                        $url,
                        'id' => $model->id
                    ]);
                    return Html::a(
                        AmosIcons::show('file'),
                        $urlview,
                        [
                            'title' => Module::t('amosproject_management', 'Read'),
                            'class' => 'btn btn-tools-secondary'
                        ]
                    );
                },
                'update' => function ($url, $model) {
                    $url = '/project_management/projects-tasks/update';
                    $urlUpdate = \Yii::$app->urlManager->createUrl([
                        $url,
                        'id' => $model->id
                    ]);
                    $loggedUser = \Yii::$app->getUser();
                    if ($loggedUser->can('PROJECTSTASKS_UPDATE', ['model' => $model])) {
                        $btnUpdate = Html::a(
                            AmosIcons::show('edit'),
                            $urlUpdate,
                            [
                                'title' => Module::t('amosproject_management', 'Edit'),
                                'class' => 'btn btn-tools-secondary'
                            ]
                        );
                    } else {
                        $btnUpdate = '';
                    }
                    return $btnUpdate;
                },
            ],
            'itemsMittente' => [
                'name' => [
                    'attribute' => 'name',
                    'label' => Module::t('amosproject_management', 'Name'),
                    'headerOptions' => [
                        'id' => Module::t('amosproject_management', 'name'),
                    ],
                    'contentOptions' => [
                        'headers' => Module::t('amosproject_management', 'name'),
                    ]
                ],
            ],
        ]);

        return $widget;
    }
}