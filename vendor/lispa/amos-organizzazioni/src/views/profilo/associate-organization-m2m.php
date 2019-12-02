<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\organizzazioni\views\profilo
 * @category   CategoryName
 */

use lispa\amos\admin\AmosAdmin;
use lispa\amos\admin\models\UserProfile;
use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\core\helpers\Html;
use lispa\amos\organizzazioni\models\Profilo;
use lispa\amos\organizzazioni\models\ProfiloUserMm;
use lispa\amos\organizzazioni\Module;
use lispa\amos\organizzazioni\widgets\JoinProfiloWidget;
use lispa\amos\organizzazioni\widgets\ProfiloCardWidget;
use yii\db\ActiveQuery;

/**
 * @var yii\web\View $this
 * @var \lispa\amos\organizzazioni\models\Profilo $model
 */

$this->title = Module::t('amosorganizzazioni', '#add_organization');
$this->params['breadcrumbs'][] = $this->title;

/** @var AmosAdmin $adminModule */
$adminModule = AmosAdmin::instance();

/** @var Module $organizzazioniModule */
$organizzazioniModule = Module::instance();

$userProfileId = Yii::$app->request->get("id");

/** @var UserProfile $userProfileModel */
$userProfileModel = $adminModule->createModel('UserProfile');
$userProfile = $userProfileModel::findOne(['id' => $userProfileId]);
$userId = $userProfile->user_id;

/** @var Profilo $organization */
$organization = $organizzazioniModule->createModel('Profilo');
/** @var ProfiloUserMm $modelProfiloUserMm */
$modelProfiloUserMm = $organizzazioniModule->createModel('ProfiloUserMm');
$profiloTable = $organization::tableName();
$profiloUserMmTable = $modelProfiloUserMm::tableName();

/** @var ActiveQuery $queryAssociated */
$queryAssociated = $modelProfiloUserMm::find();
$queryAssociated->select([$profiloUserMmTable . '.profilo_id']);
$queryAssociated->andWhere([$profiloUserMmTable . '.user_id' => $userId]);
$alreadyAssociatedOrganizationIds = $queryAssociated->column();

$query = $organization->getUserNetworkAssociationQuery($userId);
$query->andWhere(['not in', $profiloTable . '.id', $alreadyAssociatedOrganizationIds]);

/** @var Profilo $modelProfilo */
$modelProfilo = $organizzazioniModule->createModel('Profilo');

$post = Yii::$app->request->post();
if (isset($post['genericSearch'])) {
    $query->andFilterWhere(['like', $profiloTable . '.name', $post['genericSearch']]);
}

?>
<?= M2MWidget::widget([
    'model' => $model,
    'modelId' => $model->id,
    'modelData' => $query,
    'modelDataArrFromTo' => [
        'from' => 'id',
        'to' => 'id'
    ],
    'modelTargetSearch' => [
        'class' => $modelProfilo->className(),
        'query' => $query,
    ],
    'targetFooterButtons' => Html::a(Module::t('amosorganizzazioni', '#close'), Yii::$app->urlManager->createUrl([
        '/organizzazioni/profilo/annulla-m2m',
        'id' => $userProfileId
    ]), ['class' => 'btn btn-secondary', 'AmosOrganizzazioni' => Module::t('amosorganizzazioni', '#close')]),
    'renderTargetCheckbox' => false,
    'viewSearch' => (isset($viewM2MWidgetGenericSearch) ? $viewM2MWidgetGenericSearch : false),
//    'relationAttributesArray' => ['status', 'role'],
    'targetUrlController' => 'profilo',
    'targetActionColumnsTemplate' => '{joinOrganization}',
    'moduleClassName' => Module::className(),
    'postName' => 'Organization',
    'postKey' => 'organization',
    'targetColumnsToView' => [
        'logo' => [
            'headerOptions' => [
                'id' => Module::t('amosorganizzazioni', '#logo'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosorganizzazioni', '#logo'),
            ],
            'label' => Module::t('amosorganizzazioni', '#logo'),
            'format' => 'raw',//'html',
            'value' => function ($model) {
                return ProfiloCardWidget::widget(['model' => $model]);
            }
        ],
        'name',
        'created_by' => [
            'attribute' => 'created_by',
            'format' => 'html',
            'value' => function ($model) {
                /** @var Profilo $model */
                $name = '-';
                if (!is_null($model->createdUserProfile)) {
                    return $model->createdUserProfile->getNomeCognome();
                }
                return $name;
            }
        ],
        [
            'class' => 'lispa\amos\core\views\grid\ActionColumn',
            'template' => '{info}{view}{joinOrganization}',
            'buttons' => [
                'joinOrganization' => function ($url, $model) use ($userId) {
                    $btn = JoinProfiloWidget::widget(['model' => $model, 'userId' => $userId, 'isGridView' => true]);
                    return $btn;
                }
            ]
        ]
    ]
]);
?>
