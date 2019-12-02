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
use lispa\amos\projectmanagement\models\Projects;
use lispa\amos\projectmanagement\models\ProjectsCustomSpendingVoices;
use lispa\amos\projectmanagement\Module;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\widgets\PjaxAsset;

/**
 * Class ProjectOrganizationsWidget
 * @package lispa\amos\community\widgets
 */
class ProjectSpendingVoicesWidget extends Widget
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

        $model = $this->model;
        $numberOfSpendingVoices = count($model->projectsSpendingVoices);
        $gridId = 'project-spending-voices';

        PjaxAsset::register($this->getView());

        $widget = \lispa\amos\core\forms\editors\m2mWidget\M2MWidget::widget([
            'model' => $model,
            'modelId' => $model->id,
            'modelData' => $model->getProjectsSpendingVoices(),
            'overrideModelDataArr' => true,
            'forceListRender' => true,
            'createAssociaButtonsEnabled' => true,
            'disableCreateButton' => true,
            'isModal' => true,
            'gridId' => $gridId,
//            'firstGridSearch' => true,
//            'btnAssociaLabel' => Module::t('amosproject_management', 'Add Cost Item'),
            'createNewBtnLabel' => Module::t('amosproject_management', 'Create new item of expenditure' ),
            'disableAssociaButton' => true,
            'actionColumnsTemplate' => '{deleteRelation}',
            'deleteRelationTargetIdField' => 'spending_voice_parent_id',
            'targetUrl' => '/project_management/projects/associate-cost-items',
            'createNewTargetUrl' => '/project_management/projects-custom-cost-items/create?projects_id=' . $model->id,
            'moduleClassName' => Module::className(),
            'targetUrlController' => 'projects',
            'deleteActionName' => 'delete-cost-m2m',
            'postName' => 'Project',
            'postKey' => 'ProjectsCustomSpendingVoices',
            'layoutMittente' => "{itemsMittente}\n{footerMittente}",
            'permissions' => [
                'add' => 'PROJECT_MANAGER',
            ],
            'actionColumnsButtons' => [
                'deleteRelation' => function ($url, $targetModel)use ($numberOfSpendingVoices) {
                    /** @var ProjectsCustomSpendingVoices $targetModel */
                    $btnDelete = '';
                    //if($numberOfSpendingVoices > 1) {
                        $url = '/project_management/projects/delete-cost-m2m';
                        $urlDelete = Yii::$app->urlManager->createUrl([
                            $url,
                            'id' => $this->model->id,
                            'targetId' => $targetModel->id
                        ]);
                        $loggedUser = Yii::$app->getUser();
                        if ($loggedUser->can('PROJECT_MANAGER', ['model' => $this->model])) {
                            $btnDelete = Html::a(
                                AmosIcons::show('delete'),
                                $urlDelete,
                                [
                                    'title' => Module::t('amosproject_management', 'Delete'),
                                    'class' => 'btn btn-danger-inverse',
                                    'data-confirm' => Module::t('amosproject_management', 'Are you sure you want to delete this item?'),
//                                    'method' => 'ajax'
                                ]
                            );
                        } else {
                            $btnDelete = '';
                        }
                    //}
                    return $btnDelete;
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
                    ],
                ],
            ],
        ]);


        return "<div id=\"".$gridId."\" data-pjax-container=\"".$gridId . "\" data-pjax-timeout=\"10000\">".

            "<div class=\"container-tools\">".
            Html::a(Module::t('amosproject_management', 'Create new item of expenditure' ), '/project_management/projects-custom-cost-items/create?projects_id=' . $model->id, ['data-toggle' => 'modal', 'data-target' => '#new-cost-item-modal', 'class' => 'btn btn-amministration-primary']).
            "</div>"
            .$widget
            ."</div>";
//        return $widget;
    }
}