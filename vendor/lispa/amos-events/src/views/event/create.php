<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events
 * @category   CategoryName
 */

use lispa\amos\events\AmosEvents;
use lispa\amos\events\models\EventInvitationsUpload;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\Event $model
 */

$this->title = AmosEvents::t('amosevents', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $this->title;

/** @var EventInvitationsUpload $eventInvitationUploadModel */
$eventInvitationUploadModel = AmosEvents::instance()->createModel('EventInvitationsUpload');

?>
<div class="event-create">
<?= $this->render(
    '_form', 
    [
        'model' => $model,
        'upload' => $eventInvitationUploadModel,
        'fid' => null,
        'dataField' => null,
        'dataEntity' => null,
        'moduleCwh' => $moduleCwh,
        'scope' => $scope
    ]) 
?>
</div>
