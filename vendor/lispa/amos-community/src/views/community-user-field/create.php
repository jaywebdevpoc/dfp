<?php
/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    @vendor/lispa/amos-community/src/views 
 */
/**
* @var yii\web\View $this
* @var lispa\amos\community\models\CommunityUserField $model
*/

$this->title = Yii::t('amoscore', 'Crea', [
    'modelClass' => 'Community User Field',
]);
$this->params['breadcrumbs'][] = ['label' => '', 'url' => ['/community']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('amoscore', 'Community User Field'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="community-user-field-create">
    <?= $this->render('_form', [
    'community' => $community,
    'model' => $model,
    'fid' => NULL,
    'dataField' => NULL,
    'dataEntity' => NULL,
    ]) ?>

</div>
