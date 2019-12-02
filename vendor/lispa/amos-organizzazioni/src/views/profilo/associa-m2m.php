<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\community\views\community
 * @category   CategoryName
 */

use lispa\amos\core\forms\editors\m2mWidget\M2MWidget;
use lispa\amos\core\user\User;
use lispa\amos\organizzazioni\Module;

/**
 * @var \lispa\amos\core\user\User $model
 */

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => Module::t('amosorganizzazioni', 'Organizzazioni'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('amosorganizzazioni', 'Invite Users');

$query = User::find();
//$post = Yii::$app->request->post();
//if (isset($post['genericSearch'])) {
//    $query->andFilterWhere(['or',
//        ['like', UserProfile::tableName() . '.cognome', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.nome', $post['genericSearch']],
//        ['like', "CONCAT( ". UserProfile::tableName() .".nome , ' ', ". UserProfile::tableName() .".cognome )", $post['genericSearch']],
//        ['like', "CONCAT( ". UserProfile::tableName() .".cognome , ' ', ". UserProfile::tableName() .".nome )", $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.codice_fiscale', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.domicilio_indirizzo', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.indirizzo_residenza', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.domicilio_localita', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.domicilio_cap', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.cap_residenza', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.numero_civico_residenza', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.domicilio_civico', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.telefono', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.cellulare', $post['genericSearch']],
//        ['like', UserProfile::tableName() . '.email_pec', $post['genericSearch']],
//    ]);
//}

echo M2MWidget::widget([
    'model' => $model,
    'modelId' => $model->id,
    'modelData' => $model->getProfiloUsers(),
    'modelDataArrFromTo' => [
        'from' => 'id',
        'to' => 'id'
    ],
    'modelTargetSearch' => [
        'class' => User::className(),
        'query' => $query,
    ],
    'gridId' => 'organizations-employees-grid',
    'viewSearch' => (isset($viewM2MWidgetGenericSearch) ? $viewM2MWidgetGenericSearch : false),
    'isModal' => true,
    'relationAttributesArray' => ['status', 'role'],
    'targetUrlController' => 'profilo',
    'moduleClassName' => Module::className(),
    'postName' => 'Organizzazioni',
    'postKey' => 'user',
    'targetColumnsToView' => [
        'User image' => [
            'headerOptions' => [
                'id' => Module::t('amosorganizzazioni', 'User image'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosorganizzazioni', 'User image'),
            ],
            'label' => Module::t('amosorganizzazioni', 'User image'),
            'format' => 'raw',
            'value' => function ($model) {
                /** @var \lispa\amos\core\user\User $model */
                /** @var \lispa\amos\admin\models\UserProfile $userProfile */
                $userProfile = $model->getProfile();
                return empty($userProfile)
                    ? ''
                    : \lispa\amos\admin\widgets\UserCardWidget::widget([
                        'model' => $userProfile,
                        'containerAdditionalClass' => 'nom'
                    ]);
            }
        ],
        'name' => [
            'attribute' => 'profile.surnameName',
            'label' => Module::t('amosorganizzazioni', 'Name'),
            'headerOptions' => [
                'id' => Module::t('amosorganizzazioni', 'Name'),
            ],
            'contentOptions' => [
                'headers' => Module::t('amosorganizzazioni', 'Name'),
            ]
        ],
    ],
]);
