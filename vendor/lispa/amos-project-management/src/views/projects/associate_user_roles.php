<?php
use lispa\amos\projectmanagement\Module;


/** @var $model \lispa\amos\projectmanagement\models\ProjectsUserMm  */

?>

<?php
$this->params['breadcrumbs'][] = ['label' => Module::t('amosproject_management', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => strip_tags($model)];
$this->title = Module::t('amosproject_management','Add roles');


$form  = \lispa\amos\core\forms\ActiveForm::begin([
    'method' => 'post'
]);?>
<?php
if(!isset($idUserAssociated)) {
    $idUserAssociated = [];
}
$modelProfileSearch =  new \lispa\amos\admin\models\search\UserProfileSearch();
$dataProvider = $modelProfileSearch->search([]);
$dataProvider->query->andWhere(['NOT IN', 'user_profile.user_id', $idUserAssociated])

?>
<div class="col-lg-6">
    <?php if($model->isNewRecord) {
        echo $form->field($model, 'user_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map($dataProvider->models, 'id', 'user.userProfile.nomeCognome'),
            'options' => ['id' => 'user-id', 'placeholder' => Module::t('amosproject_management', 'Select...')]
        ]);
    }
    else {
        echo "<div class='m-t-35'>"
            .Module::t('amosproject_management','Nome e cognome')
            .": <strong>" . \lispa\amos\admin\models\UserProfile::find()->andWhere(['user_id' => $model->user_id])->one(). "</strong>
            </div>";
    }?>
</div>

<div class="col-lg-6">
    <?php
    $className = Module::getModuleOrganization()->getOrganizationModelClass();
    if(!empty($model->organization_id)) {
        $org  = $className::findOne($model->organization_id);
        $org_id = $org->id;
        $org_name = $org->name;
    }?>
    <?php
    if($model->isNewRecord) {
        echo $form->field($model, 'organization_id')->widget(\kartik\depdrop\DepDrop::classname(), [
            'options' => ['id' => 'organization-id'],
            'type' => \kartik\depdrop\DepDrop::TYPE_DEFAULT,
            'pluginOptions' => [
                'depends' => ['user-id'],
                'placeholder' => Module::t('amosproject_management', 'Select...'),
                'initialize' => true,
                'url' => \yii\helpers\Url::to(['projects/user-organizations'])
            ]
        ]);
    }
    else {
        $className = \lispa\amos\projectmanagement\Module::getModuleOrganization()->getOrganizationModelClass();
        $modelOrgSearch = new \lispa\amos\projectmanagement\models\search\OrganizationsSearch();
        $dataProvider = $modelOrgSearch->userOrganizationsSearch($model->user_id);
        echo $form->field($model, 'organization_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \yii\helpers\ArrayHelper::map($dataProvider->query->all(), 'id', 'name'),
            'options' => ['id' => 'user-id', 'placeholder' => Module::t('amosproject_management', 'Select...')]
        ]);
    }
     ?>
</div>

<div class="col-lg-6">
    <?php

        $data = \yii\helpers\ArrayHelper::map(\lispa\amos\projectmanagement\models\ProjectsRoles::find()->all(), 'id', 'name');
        $data = \lispa\amos\projectmanagement\controllers\ProjectsController::transarray($data);

    echo $form->field($model, 'projects_role_id')->widget(\kartik\select2\Select2::className(), [
        'data' =>$data,
        'options' => [
                'placeholder' => Module::t('amosproject_management', 'Select...')
             ]
    ]);?>
</div>
<div>
    <?php echo \lispa\amos\core\forms\CloseSaveButtonWidget::widget([
        'model' => $model
    ]);?>
</div>
<?php \lispa\amos\core\forms\ActiveForm::end(); ?>
