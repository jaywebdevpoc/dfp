<?php

/**
 * Lombardia Informatica S.p.A.
 * OPEN 2.0
 *
 *
 * @package    lispa\amos\events\views\event
 * @category   CategoryName
 */

use lispa\amos\core\forms\ActiveForm;
use lispa\amos\core\helpers\Html;
use lispa\amos\events\AmosEvents;

/**
 * @var yii\web\View $this
 * @var lispa\amos\events\models\Event $event
 * @var lispa\amos\events\models\EventInvitationsUpload $upload
 * @var yii\widgets\ActiveForm $form
 * @var string $fid
 */

$this->title = AmosEvents::txt('#upload_invitations_header');
$this->params['breadcrumbs'][] = ['label' => Yii::$app->session->get('previousTitle'), 'url' => Yii::$app->session->get('previousUrl')];
$this->params['breadcrumbs'][] = $event->title;

?>
<div class="upload-invitations-modal">
<?php
$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data' // important
    ]
]);
?>

<div class="event-form">
    <h2><?= $event->title ?></h2>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <?= $form->field($upload, 'excelFile')->fileInput()->hint(AmosEvents::txt('#invitations_excel_file_hint')) ?>
        </div>
    </div>
    <div>
        <?= Html::submitButton('Importa', ['class' => 'btn']) ?>
    </div>
</div>

<?php
ActiveForm::end();
?>
</div>
